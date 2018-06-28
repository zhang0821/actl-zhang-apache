var tem_hum,ifRefresh_temp=0,ifRefresh=0,ifRefresh_humi=0;
var init_temp=[];//概览曲线
var init_humi=[];
var init_time=[];

function time_differ_minutes(time_last,time_now,minutes){
    var a=time_last+":00",b=time_now+":00";
    s=a.split(":");
    e=b.split(":");
    var daya = new Date();
    var dayb = new Date();
    daya.setHours(s[0]);
    dayb.setHours(e[0]);
    daya.setMinutes(s[1]);
    dayb.setMinutes(e[1]);

     if(((dayb-daya)/1000/60)>minutes || (dayb-daya)<0){//
//console.log("小时间"+time_last+"大时间"+time_now+"b比a多了："+(dayb-daya)/1000/60+"分钟");
        return 1;
     }
     else{
        return 0;
     }
   
}
function graph(floor_id,room_id){//画大曲线图
   /* $(".graph").css("display",'block').css("z-index",'100');
    ifStartGraph=1;//开始记录指定房间传入的温湿度值到数组中
    graphRM_id=room_id;
    graphFL_id=floor_id;
    graphCurve();*/
}
//各房间实时曲线
function graphCurve(){
    Highcharts.setOptions({                                                     
        global: {                                                               
            useUTC: false                                                       
        }                                                                       
    }); 
    $(".graphBox").empty();
    $(".graphBox").highcharts({        
        chart: {    
            backgroundColor: '#000',        
            type: 'spline',                                                             
            marginRight: 0,  
            events: {                                                          
                load: function() {
                    var series0 = this.series[0];
                    var series1=this.series[1];
                    // series0.setData(tem_hum_value_array[0]);
                    // series1.setData(tem_hum_value_array[0]);
                    setInterval(function () {
                        if(tem_hum_value_array[0].length>10) 
                        {
                            tem_hum_value_array[0].shift();
                            tem_hum_value_array[1].shift();
                            tem_hum_value_array[2].shift();
                        } 
						series0.setData([]);
                        series1.setData([]); 
                  
                        series0.setData(tem_hum_value_array[1]);//动态更新值，对应到下面每条曲线的Y值
                        series1.setData(tem_hum_value_array[2]);                            
                    }, 5000);  
                }
            }                                                                   
        },                                                                       
        title: {                                                                
            text: '温湿度曲线',
            style:{
                    fontSize: '20px',
                    fontWeight:"bold",
                    fontFamily:"微软雅黑",
                    color:"#446F9E"
                }           
        },                                                                     
        xAxis: { 
            gridLineDashStyle :'Dash',                                                            
            title: {
                    // enabled: true,
                    text: '时间',
                    style:{
                        fontSize: '18px',
                        fontWeight:"bold",
                        fontFamily:"微软雅黑",
                        color:"#446F9E"
                    }   
                },
                categories:tem_hum_value_array[0],
                tickPixelInterval:50                                             
        },                                                                      
        yAxis: {
            gridLineDashStyle:'longdash',//针对的是横向的网格线    
            title: {                                                            
                text: '温度(℃) / 湿度(%RH)' ,
                style:{
                    fontSize: '18px',
                    fontWeight:"bold",
                    fontFamily:"微软雅黑",
                    color:"#446F9E"
                }               
            }                                                                
        },
        credits: {
            enabled: false
        },
        // legend: {                                                               
        //     enabled: true ,
        //     borderRadius: 10,
        //     itemHoverStyle:{
        //         color:'#fff',
        //         fontSize: "16px"
        //     },
        //     itemStyle:{
        //         color:'#446F9E'
        //     }
                                                      
        // },                                                                      
        exporting: {                                                            
            enabled: true                                                      
        },
        tooltip:{
            backgroundColor: '#ccc',   // 背景颜色
            borderColor: '#fff',         // 边框颜色
            borderRadius: 10,             // 边框圆角
            borderWidth: 1,               // 边框宽度
            // animation: true ,              // 是否启用动画效果
            style: {                      // 文字内容相关样式
                  color: "#fff",
                  fontSize: "14px"
                },
                valueDecimals: 1//设置小数点位数

        } ,                                                                     
        series: [{                                                              
            name: '温度',                                                
            data: []  ,
            color:'#fff' , //legend 圆点颜色   
            // BorderWidth:50  ,//提示框的宽度
             marker: {
                radius: 10,  //曲线点半径，默认是4
                symbol: 'triangle' //曲线点类型："circle", "square", "diamond", "triangle","triangle-down"，默认是"circle"
            },
            tooltip: {
                valueSuffix: ' ℃',
            }                              
        },{                                                              
            name: '湿度',                                                
            data: []  ,
            color:'#ccc' ,
            // BorderWidth:7  ,
            tooltip: {
                valueSuffix: ' %RH',
            }                   
        }
        ]                                                                                                                                               
    });
}
//画概览曲线
function graph_overview(address1,address2){
    init_info("all");//初始化整个楼栋的初始数据
    refresh_points();
    // setInterval(function(){refresh_points();},5000);
    overGraphTemp(address1);
    overGraphHumi(address2);

}
function refresh_points(){
    tem_hum_time=get_floorInfo_db();//0:温度，1:湿度
    var over_time_flag=time_differ_minutes(init_time[(init_time.length-1)],tem_hum_time[2],5);
//console.log("之前画图数组温度"+init_temp);
//console.log("画图数组时间"+init_time);
    //if(Math.abs(tem_hum_time[0]-init_temp[(init_temp.length-1)])>0.5 )
    if(Math.abs(tem_hum_time[0]-init_temp[(init_temp.length-1)])>0.5 || Math.abs(tem_hum_time[1]-init_humi[(init_humi.length-1)]>1) || over_time_flag)
    {
        init_temp.push(tem_hum_time[0]);
        init_humi.push(tem_hum_time[1]);
        init_time.push(tem_hum_time[2]);//时间也要更新
        ifRefresh=1;
        
    }
}
//备份画图曲线
function myoverGraphTemp(address){
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
    $(address).highcharts({
        colors: ['red','red'],
        chart: {
            backgroundColor:'rgba(0,0,0,0.95)',
            type: 'spline',
            animation: Highcharts.svg, // don't animate in old IE
            marginRight: 10,
            events: {
                load: function () {
                    // set up the updating of the chart each second
                    var series = this.series[0],
                        chart = this;
                    setInterval(function () {
                        var x = (new Date()).getTime(), //current time
                            y = tem_hum[0];
                        if(ifRefresh_temp==1){
                            series.addPoint([x, y], true, true);
                            activeLastPointToolip(chart);
                            ifRefresh_temp=0;
                            // last_info.time=x;
                        }
                    }, 5000);
                }
            }
        },
        title: {
            text: '温度平均数据',
            style:{
                    fontSize: '25px',
                    fontFamily:"微软雅黑",
                    color:"rgba(255,255,255,0.9)",
                }
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 1,
            labels:{  
                enabled:false  
             }
        },
        yAxis: {
		 

            gridLineDashStyle:'longdash',//针对的是横向的网格线 
            gridLineColor: '#fff',//横向网格线颜色
            title: {
                text: '温度(℃)',
                style:{
                    fontSize: '16px',
                    fontFamily:"微软雅黑",
                    color:"#446F9E",
                }
            },
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
                    Highcharts.numberFormat(this.y, 2);
            },
            style: {                      // 文字内容相关样式
                  color: "#fff",
                  fontSize: "14px",

            }
        },
        legend: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        series: [{
            name: '温度值',
            data: (function () {
                // generate an array of random data
                var data = [],
                    time = (new Date()).getTime(),
                    i,j=0;
                for (i = -9; i <= 0; i++) {
                    data.push({
                        x: time + i * 60000*120,
                        y: init_temp[j]
                    });
                    j++;
                }
                return data;
            }())
        }]
    }, function(c) {
        activeLastPointToolip(c)
    });
}

//概览主页面的温湿度
function overGraphTemp(address){
    Highcharts.setOptions({                                                     
        global: {                                                               
            useUTC: false                                                       
        }                                                                       
    }); 
    $(address).highcharts({        
        chart: { 
        color:['#fff','#000'],
            backgroundColor: '#000',        
            type: 'spline',                                                     
            // animation: Highcharts.svg,         
            marginRight: 0,  
            events: {                                                          
                load: function() {
                    var series= this.series[0];
                    series.setData(init_temp);
                    setInterval(function () {
                        refresh_points();
                        if(ifRefresh==1) 
                        {
                            init_time.shift();
                            init_temp.shift();
                            init_humi.shift();
                            ifRefresh=0;

                        } 
			series.setData([]);                    
                        series.setData(init_temp);//动态更新值，对应到下面每条曲线的Y值        
//console.log("温度之后画图数组温度"+init_temp);
//console.log("画图数组时间"+init_time);                  
                    }, 30000);  
                }
            }                                                                   
        },                                                                       
        title: {                                                                
            text: '温度实时平均数据',
            style:{
                    fontSize: '20px',
                    fontWeight:"bold",
                    fontFamily:"微软雅黑",
                    color:"#446F9E"
                }           
        },                                                                     
        xAxis: { 
            gridLineWidth :'0', //默认是0，即在图上没有纵轴间隔线                                                            
            labels:{  
                enabled:false  
             },
                categories:init_time,
                tickPixelInterval:50                                             
        },                                                                      
        yAxis: {
		
                min:-10, // 定义最小值  
                tickInterval:10, // 刻度间隔

            gridLineDashStyle:'Dash',//针对的是横向的网格线 
            gridLineColor: '#ccc',//横向网格线颜色
            // gridLineWidth: 0,//横向网格线宽度
            title: {                                                            
                text: '温度(℃)' ,
                style:{
                    fontSize: '18px',
                    fontWeight:"bold",
                    fontFamily:"微软雅黑",
                    color:"#446F9E"
                }               
            }                                                                 
        },
        credits: {
            enabled: false
        },
        legend: {                                                               
            enabled: false                                  
        },                                                                      
        exporting: {                                                            
            enabled: false                                                      
        },
        tooltip:{
            backgroundColor: '#ccc',   // 背景颜色
            borderColor: '#fff',         // 边框颜色
            borderRadius: 10,             // 边框圆角
            borderWidth: 1,               // 边框宽度
            // animation: true ,              // 是否启用动画效果
            style: {                      // 文字内容相关样式
                  color: "#fff",
                  fontSize: "14px"
                },
                valueDecimals: 1//设置小数点位数

        } ,                                                                     
        series: [{                                                              
            name: '温度',                                                
            data: [],
            color:'#fff' , //legend 圆点颜色   
             marker: {
                radius: 10,  //曲线点半径，默认是4
                symbol: 'triangle' //曲线点类型："circle", "square", "diamond", "triangle","triangle-down"，默认是"circle"
            },
            tooltip: {
                valueSuffix: ' ℃',
            }                              
        }]                                                                                                                                               
    });
}
function overGraphHumi(address){
    Highcharts.setOptions({                                                     
        global: {                                                               
            useUTC: false                                                       
        }                                                                       
    }); 
    $(address).highcharts({        
        chart: {    
            backgroundColor: '#000',        
            type: 'spline',                                                     
            // animation: Highcharts.svg,         
            marginRight: 0,  
            events: {                                                          
                load: function() {
                    var series= this.series[0];
                    series.setData(init_temp);
                    setInterval(function () {
                        // refresh_points();
                        if(ifRefresh==1) 
                        {
                            init_time.shift();
                            init_temp.shift();
                            init_humi.shift();
                            ifRefresh=0;

                        }    
			series.setData([]);               
                        series.setData(init_humi);//动态更新值，对应到下面每条曲线的Y值  
//console.log("湿度之后画图数组温度"+init_temp);
//console.log("画图数组时间"+init_time);                        
                    }, 5000);  
                }
            }                                                                   
        },                                                                       
        title: {                                                                
            text: '湿度实时平均数据',
            style:{
                    fontSize: '20px',
                    fontWeight:"bold",
                    fontFamily:"微软雅黑",
                    color:"#446F9E"
                }           
        },                                                                     
        xAxis: { 
            gridLineDashStyle:'Dash',
            categories:init_time,
            tickPixelInterval:50                                             
        },                                                                      
        yAxis: {
		min:10, // 定义最小值  
                tickInterval:10, // 刻度间隔

            gridLineDashStyle:'Dash',//针对的是横向的网格线 
            gridLineColor: '#ccc',//横向网格线颜色
            // gridLineWidth: 0,//横向网格线宽度
            title: {                                                            
                text: '湿度(%RH)' ,
                style:{
                    fontSize: '18px',
                    fontWeight:"bold",
                    fontFamily:"微软雅黑",
                    color:"#446F9E"
                }               
            }                                                                 
        },
        credits: {
            enabled: false
        },
        legend: {                                                               
            enabled: false
            // borderRadius: 10,
            // itemHoverStyle:{
            //     color:'#fff',
            //     fontSize: "16px"
            // },
            // itemStyle:{
            //     color:'#446F9E'
            // }
                                                      
        },                                                                      
        exporting: {                                                            
            enabled: false                                                      
        },
        tooltip:{
            backgroundColor: '#fff',   // 背景颜色
            borderColor: '#fff',         // 边框颜色
            borderRadius: 10,             // 边框圆角
            borderWidth: 1,               // 边框宽度
            // animation: true ,              // 是否启用动画效果
            style: {                      // 文字内容相关样式
                  color: "#fff",
                  fontSize: "14px"
                },
                valueDecimals: 1//设置小数点位数

        } ,                                                                     
        series: [{                                                              
            name: '湿度',                                                
            data: [],
            color:'#fff' , //legend 圆点颜色   
             marker: {
                radius: 10,  //曲线点半径，默认是4
                symbol: 'circle' //曲线点类型："circle", "square", "diamond", "triangle","triangle-down"，默认是"circle"
            },
            tooltip: {
                valueSuffix: '%Rh',
            }                              
        }]                                                                                                                                               
    });
}
//概览曲线初始画图数据请求

function init_info(type){
    var time=[];
    var FL_id=-1,RM_id=-1;
    if(type=="floor"){
        FL_id=graphFL_id;
        RM_id=graphRM_id;
    }
    $.ajax({
        type:'POST',
        url: "../app/index.php/Home/Info/send_init_info",
        dataType: "json",
        data:{"floor_id":graphFL_id,"room_id":graphRM_id},
        async: false ,
        success: function(data){
            if(data){
                if(type=="all"){
                    for(var i=0;i<(data.length);i++){
                        init_temp[i]=Number(data[i].temp);
                        init_humi[i]=Number(data[i].humi);
                        init_time[i]=data[i].time;
                    }
                }
                // if(type=="floor"){
                //     for(var i=0;i<(data.length);i++){
                //         tem_hum_value_array[0].push(data[i].time);
                //         tem_hum_value_array[1].push(data[i].temp_average);
                //         tem_hum_value_array[2].push(data[i].humi_average);
                //     }
                // }

                //console.log("时间戳"+init_time+"时间："+time);
            }
            else{
                alert("无法请求到楼层的温湿度数据");
            }
        }
    });
}

//数据库中读取该楼栋温湿度平均值
function get_floorInfo_db(){
    var floorCount=7;
    var data_temp_humi=new Array(3);
    $.ajax({
        type:'POST',
        url: "../app/index.php/Home/Info/send_average_tem_hum",
        dataType: "json",
        async: false ,
        data:{"floorCount":floorCount},
        success: function(data){
            if(data){
                data_temp_humi[0]=Number(data.temp_average);
                data_temp_humi[1]=Number(data.humi_average);
                data_temp_humi[2]=data.time;
            }
            else{
                alert("无法请求到楼层的温湿度数据");
            }
        }

    });
    return data_temp_humi;
}
//绘制历史查询曲线
function graphHisCurve(date,type){
    alert(tem_hum_history[0][0].humi);
    
    var temp=[],humi=[],time_x=[],seriesShow=[];
    for(var i=0;i<tem_hum_history.length;i++)//共有tem_hum_history.length这么多条曲线
    {
        temp[i]=[];
        humi[i]=[];
        for(var j=0;j<24;j++){
            temp[i].push(tem_hum_history[i][j].temp);
            humi[i].push(tem_hum_history[i][j].humi); 
            if(i==(tem_hum_history.length-1)){
                time_x.push(tem_hum_history[i][j].time);
            }
        }
    }
    var dataShow=temp,titleShow='第前'+date+'天平均温度情况',formatSymbol='℃',formatText='温度';
    if(type=='humi'){
        dataShow=humi;
        titleShow='第前'+date+'天平均湿度情况';
        formatSymbol='%RH';
        formatText='湿度';
    }
    for(var i=0;i<tem_hum_history.length;i++)
    {
        var jsonText={"name": (i+1)+"楼","data":dataShow[i]};
        seriesShow.push(jsonText);
    }
    $('#hisDataContainer').empty();
    $(function () {
        $('#hisDataContainer').highcharts({
            chart: {
                type: 'line',
                background:'#000'
            },
            color:["#fff",'#000','#ccc','#999','#333','#555'],
            title: {
                text: titleShow,
                style:{
                        fontSize: '20px',
                        fontWeight:"bold",
                        fontfamily:'微软雅黑'               
                    }         
            },
            subtitle: {
                text: '历史数据'
            },
            xAxis: {

                categories: time_x
                 },
            yAxis: {
                gridLineDashStyle:'Dash',//针对的是横向的网格线 
                gridLineColor: '#ccc',//横向网格线颜色
                title: {
                    text: formatText+formatSymbol                
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true,
                        formatter: function() {return '<b style="font-size:15px;">'+this.y+''+formatSymbol+'</b>';}
                    },
                    enableMouseTracking: false
                }
            },
            credits: {
                enabled: false
            },
            series: seriesShow
        });
    });
}