var monitorApp = angular.module('monitorApp', [
    'ngRoute', 'ngAnimate', 'loraMonitorCtrls']);

var loraMonitorCtrls = angular.module('loraMonitorCtrls', []);

var html_annotate=0;
loraMonitorCtrls.controller('sensorShow', ['$scope','$http','$interval',function($scope,$http,$interval){
    $scope.toDo=function(event){
        console.log("点击元素的内容是"+event.target.textContent);
        if(event.target.textContent<70) {
            console.log("小于70");
        }
        else{
            console.log("大于70");
        }
    };
    var mydata=new Array();
    var parentHeight=document.getElementById("TemHumBoxMain").offsetHeight;
    var parentWidth=document.getElementById("TemHumBoxMain").offsetWidth;

    $interval(function(){
        $http({
            method:'post',
            url:"../app/index.php/Home/Info/send_SsInfo_web",
            dataType:'JSON',
        }).success(function(data,statis,headers,config){
            var data_SENSOR=data;
            var annotate={};
            //console.log("样式界面输出的数据是data.length："+data.length);
            mydata.length=0;
            for(var i=0;i<data_SENSOR.length;i++){
                
                for(let j=0;j<data_SENSOR[i].length;j++)
                {
                         var mydata_child={};
                        //统计共有哪些类型的节点
                        if(data_SENSOR[i][j].type in annotate){
                            annotate[data_SENSOR[i][j].type]++;
                        }
                        else{
                            annotate[data_SENSOR[i][j].type]=1;
                        }  
                    //节点展示
        	        data_SENSOR[i][j].value_hidden=1;
                    data_SENSOR[i][j].posx=Math.round(parentWidth*data_SENSOR[i][j].posx)-15;
                    data_SENSOR[i][j].posy=Math.round(parentHeight*data_SENSOR[i][j].posy)-15;
                    if(data_SENSOR[i][j].ifWarn==2){//离线
                    	data_SENSOR[i][j].type='5';
                    }else if(data_SENSOR[i][j].ifWarn==0){//报警
                        data_SENSOR[i][j].type='0';
                        if(data[i][j].type=='smoke'){
                            data_SENSOR[i][j].type='6';
                        }
                    }

//else if(data[i][j].ifWarn==undefined){
                            		//data_SENSOR[i][j].type='0';
                       		 //}


else{
                        if(data_SENSOR[i][j].type=='tem_hum'){
                            data_SENSOR[i][j].type='1';
                            data_SENSOR[i][j].value_hidden=0;
                            data_SENSOR[i][j].posx-=15;
                            data_SENSOR[i][j].posy-=5;
				
                        }
                        if(data_SENSOR[i][j].type=='smoke'){
                            data_SENSOR[i][j].type='2';
                        }
                        if(data_SENSOR[i][j].type=='door'){
                            data_SENSOR[i][j].type='3';
                        }
                        if(data_SENSOR[i][j].type=='water'){
                            data_SENSOR[i][j].type='4';
                        }
                    }
                    mydata.push(data_SENSOR[i][j]);
                }
            }
 //显示注释的节点类型
            
        if(html_annotate==0 )
        {
            var html='';
            for(var y in annotate){
                var senserName='';
                switch(y){
                    case 'tem_hum':
                        senserName='温湿度';
                        break;
                    case 'door':
                        senserName='门禁';
                        break;
                    case 'smoke':
                        senserName='烟雾';
                        break;
                    default:
                        senserName='水浸';
                }
                html+='<li class="annotate_'+y+'"><div></div><p>'+senserName+'节点</p></li>';
            }
            html+='<li class="annotate_abnormal"><div></div><p>异常节点</p></li><li class="annotate_offline"><div></div><p>离线节点</p></li>';
            //console.log("++++++++++++html:"+html);
    	    html_annotate=1;
            $(".annotate").empty().append(html); 
            //if(click_id!=2){$(".annotate").css("display","none");}
        }
    }).error(function(data,statis,headers,config){
        console.log("error");
    });
    },6000);  

     $scope.sensors1=mydata; 
}]);




var music_warn_on=0;
//表单
loraMonitorCtrls.controller('tableBind', ['$scope','$http','$interval', function($scope,$http,$interval){
let myData=new Array();
    $interval(function(){
        $http({
            method:'post',
            url:"../app/index.php/Home/Info/send_SsInfo_web",
            dataType:'JSON',
        }).success(function(data,statis,headers,config){
        var music_warn=0;
        if(if_timer_clear==1){
            click_lunbo();if_timer_clear=0;
        }
        infoBox.length=0;
        myData.length=0;  
            for(let k=0;k<data.length;k++){
                for(let kk=0;kk<data[k].length;kk++){
console.log("data[k][kk]['ifWarn']:"+data[k][kk]['ifWarn']);
                    let ifExsit=0;
                    let posJ=0;
                    for(let j=0;j<myData.length;j++){
                        if(data[k][kk]['room_id'] == myData[j]['room_id']){
                            ifExsit=1;
                            posJ=j;
                        }
                    }
                    if(ifExsit==0){
                        let obj={};
                        obj=data[k][kk];
                        if(obj['temp_value']==9999)
                        {
                            obj['temp_value']=0;
                            obj['humi_value']=0;
                        }
                        obj['water']='正常';
                        obj['door']='关';
                        obj['smoke']='正常';
                        obj['ifWarn']=1;
                        myData.push(obj);
                    }
                    else{
                         if(data[k][kk]['ifWarn']==0){
                                myData[posJ]['ifWarn']=0;
                                if(data[k][kk]['type']=='water'){
                                    myData[posJ]['water']='报警';
                                    infoBox.push(data[k][kk]['floor_name']+','+data[k][kk]['room_id']+'有水浸传感器报警;');
                                }
                                if(data[k][kk]['type']=='tem_hum'){
                                     infoBox.push(data[k][kk]['floor_name']+','+data[k][kk]['room_id']+'有温湿度传感器异常;');
                                }
                                if(data[k][kk]['type']=='door')
                                    myData[posJ]['door']='开';
                                if(data[k][kk]['type']=='smoke'){
                                    myData[posJ]['smoke']='报警';
                                    music_warn=1;
                                     infoBox.push(data[k][kk]['floor_name']+','+data[k][kk]['room_id']+'有烟雾传感器报警;');
                                }
                            }
				 if(data[k][kk]['ifWarn']==2){
                            //if(data[k][kk]['ifWarn']==2 &&  myData[posJ]['ifWarn']!=0){
                                 infoBox.push(data[k][kk]['floor_name']+','+data[k][kk]['room_id']+'有节点离线;');
                                myData[posJ]['ifWarn']=2;
                                if(data[k][kk]['type']=='water')
                                    myData[posJ]['water']='存在离线节点';
                                if(data[k][kk]['type']=='door')
                                    myData[posJ]['door']='存在离线节点';
                                if(data[k][kk]['type']=='smoke')
                                    myData[posJ]['smoke']='存在离线节点';
                            }
                            if(data[k][kk]['temp_value']!=9999 && !(data[k][kk]['temp_value']!=data[k][kk]['temp_value'])){
                                 myData[posJ]['temp_value']=Math.round((data[k][kk]['temp_value']+ myData[posJ]['temp_value'])/2*100)/100;
                                 myData[posJ]['humi_value']=Math.round((data[k][kk]['humi_value']+ myData[posJ]['humi_value'])/2*100)/100;
                            }
//console.log("myData[posJ]['ifWarn']"+myData[posJ]['ifWarn']);
                    }
                }
            }
            notifyMSG();
            for(let i=0;i<myData.length;i++)
            {
                if(myData[i]['temp_value']!=myData[i]['temp_value'])
                {
                    myData[i]['temp_value']='--';
                    myData[i]['humi_value']='--';
                }
            }
            if(music_warn==1){
                if(music_warn_on==0)
                {
                    $("#music")[0].play();
                }
                music_warn=0;
                music_warn_on=1;
            }
            else{
                if(music_warn_on==1)
                {
                    $("#music")[0].pause();                 
                }
                music_warn_on=0;
            } 
        }).error(function(data,statis,headers,config){
            console.log("error");
        });
    },6000);
    $scope.SSinfo=myData;
}]);