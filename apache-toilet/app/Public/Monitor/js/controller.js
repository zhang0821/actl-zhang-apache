var toilet_data=[{
	location_title:'九号楼二楼东侧',
	style:{
		"top":"100px",
		"left":"30px",
		"background":"green"
	},
	detection:{
			"temp":
			{
				name:"温度",
				manValue:"18℃",
				womanValue:"19℃"
			},
			"smoke":
			{
				name:"烟雾",
				manValue:1,
				womanValue:1
			},
			"humi":
			{
				name:"湿度",
				manValue:"60%Rh",
				womanValue:"60%Rh"
			},
			"h2s":
			{
				name:"硫化氢",
				manValue:"0.3mg",
				womanValue:"0.2mg"
			},
			"nh4":
			{
				name:"氨气",
				manValue:"0.1mg",
				womanValue:"0.5mg"
			},
			"number":
			{
				name:"流量",
				manValue:"100",
				womanValue:"200"
			}
	},
	id:'node0',
	name:'9_2_东',
	location:"九号楼二楼东侧",
	woman:[
			{
				name:'女1',
				type:'0'
			},{
				name:'女2',
				type:'2'
			},{
				name:'女3',
				type:'1'
			}
		],
	man:[
			{
				name:'男1',
				type:'0'
			},{
				name:'男2',
				type:'2'
			},{
				name:'男3',
				type:'1'
			},{
				name:'男4',
				type:'1'
			}
		]
	},{
	location_title:'九号楼二楼西侧',
	style:{
		"top":"400px",
		"left":"100px",
		"background":"yellow"
	},
	detection:{
			"temp":
			{
				name:"温度",
				manValue:"1℃",
				womanValue:"19℃"
			},
			"smoke":
			{
				name:"烟雾",
				manValue:1,
				womanValue:1
			},
			"humi":
			{
				name:"湿度",
				manValue:"6%Rh",
				womanValue:"6%Rh"
			},
			"h2s":
			{
				name:"硫化氢",
				manValue:"0.03mg",
				womanValue:"0.02mg"
			},
			"nh4":
			{
				name:"氨气",
				manValue:"0.01mg",
				womanValue:"0.05mg"
			},
			"number":
			{
				name:"流量",
				manValue:"10",
				womanValue:"20"
			}
		},
	// posx:'400px',
	// top:'100px',
	id:'node1',
	name:'9_2_西',
	location:"九号楼二楼西侧",
	woman:[
			{
				name:'女x1',
				type:'0'
			},{
				name:'女x2',
				type:'2'
			},{
				name:'女x3',
				type:'1'
			},{
				name:'女x4',
				type:'1'
			},{
				name:'女x5',
				type:'1'
			}
		],
	man:[
			{
				name:'男x1',
				type:'0'
			},{
				name:'男x2',
				type:'2'
			},{
				name:'男x3',
				type:'1'
			},{
				name:'男x4',
				type:'1'
			},{
				name:'男x5',
				type:'0'
			},{
				name:'男x6',
				type:'2'
			},{
				name:'男x7',
				type:'1'
			},{
				name:'男x8',
				type:'1'
			}
		]
	}
]


var node_click=function(name){
	name='node1';
	console.log("点击函数"+name);
	//choice_id=parseInt(name);//如果字符串前面有非数字字符，此法不能取出数字
	choice_id=parseInt(name.replace(/[^0-9]/ig,""));//取出数字部分
	// document.getElementById("title_left").innerHTML='{{location_title'+name+'}}';
	// document.getElementById("man").innerHTML='<div ng-repeat="node in man'+name+' track by $index"  ng-class="0:"style_empty",1:"style_occupi",2:"style_warn"}[{{node.type}}]"><p>{{node.name}}</p></div>';
	$("#location_title").append(name);
	var target=document.getElementById("detial");
	target.style.cssText='display:block;z-index:10;';
}

/*
var response_apache=function(){
	var xhr=null;
	if(window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }else {
        xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xhr.open('POST','../Monitor/getResponse',true);
    xhr.onreadystatechange=function(){
    	if(xhr.readyState == 4 && (xhr.status== 200 || xhr.status== 304)){
    		console.log("成功返回数据"+xhr.responseText);
    	}
    }
    xhr.send();

}

var render_info=function(data){
	$("#map").empty();
	var html='';
	console.log(data.length);
	var color='green';
	console.log("渲染数据的长度"+data.length);
	for(let i=0;i<data.length;i++){
		if(data[i].detection.smoke.womanValue==1 || data[i].detection.smoke.manValue==1){
			color='red';
		}
		html+=`<div id=${data[i].id} value=${data[i].location} style="top:${data[i].style.top};`+
		`left:${data[i].style.left};background:${color}" onclick=node_click(${data[i].id})>`+
		`${data[i].detection.smoke.name}<div>`;
	}
	console.log(html);
	$("#map").append(html);
	response_apache();
}

var ask_Info=function(){
	var xhr=null;
	if(window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }else {
        xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xhr.open('POST','../Monitor/node_info',true);
    xhr.onreadystatechange=function(){
    	if(xhr.readyState == 4 && (xhr.status== 200 || xhr.status== 304)){
    		console.log("周期性返回数据"+xhr.responseText);
    		if(xhr.responseText){
    			var data=JSON.parse(xhr.responseText);
    			render_info(data);
    		}
    	}
    }
    xhr.send();
}

*/
var response_apache=function(dev_eui,id){
	var dataRes={
		"dev_eui":dev_eui,
		"id":id
	}
	var xhr=null;
	if(window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }else {
        xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xhr.open('POST','../Monitor/getResponse',true);
    xhr.onreadystatechange=function(){
    	if(xhr.readyState == 4 && (xhr.status== 200 || xhr.status== 304)){
    		console.log("成功返回数据"+xhr.responseText);
    	}
    }
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); 
    xhr.send("dev_eui="+dev_eui+"&id="+id);
}
/*
var render_info=function(data){
	$("#map").empty();
	var html='';
	console.log(data.length);
	var color='green';
	console.log("渲染数据的长度"+data.length);
	for(let i=0;i<data.length;i++){
		if(data[i].detection.smoke.womanValue==1 || data[i].detection.smoke.manValue==1){
			color='red';
		}
		html+=`<div id=${data[i].id} value=${data[i].location} style="position:absolute;top:${data[i].style.top};`+
		`left:${data[i].style.left};background:${color}" onclick=node_click(${data[i].id})>`+
		`${data[i].detection.smoke.name}<div>`;
	}
	console.log(html);
	$("#map").append(html);
	response_apache(11,22);
}
*/

var render_info=function(data){
	$("#map").empty();
var no=0;
	var html='';
	var color='green';
	console.log("渲染数据的长度"+data.length);
	for(let i=0;i<data.length;i++){
		if(data[i].status==0){
			color='red';
			no=i;
		}
		if(data[i].status<0){
			color='#ccc';
		}
/*
		html+=`<div id=node${data[i].id} value=${data[i].room_id} style="top:${(data[i].posy)*500}px;`+
		`left:${(data[i].posx)*900}px;background:${color}" onclick=node_click(${data[i].id})>`+
		`${data[i].room_id}--${data[i].send_time}<div>`;
*/
	html+='<div id=node"+data[i].id+" value="+data[i].room_id+" style="top:"+(data[i].posy)*500+"px;'+
		'left:"+(data[i].posx)*900+"px;background:"+color+" onclick=node_click("+data[i].id+")>'+
		data[i].room_id+"--"+data[i].send_time+'<div>';

	}
	//console.log(html);

	$("#map").append(html);

console.log(data[no].dev_eui+"///"+data[no].id);
response_apache(data[no].dev_eui,data[no].id);

}


var ask_Info=function(){
	var xhr=null;
	if(window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }else {
        xhr = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xhr.open('POST','../Monitor/node_info',true);
    xhr.onreadystatechange=function(){
    	if(xhr.readyState == 4 && (xhr.status== 200 || xhr.status== 304)){
    		//console.log("周期性返回数据"+xhr.responseText);
    		if(xhr.responseText){
    			var data=JSON.parse(xhr.responseText);
			//console.log(data);
    			render_info(data);
    		}
    	}
    }
    xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded;"); 
//    xhr.send(JSON.stringify({name:'zhang'}));
xhr.send("info=zhang&sex=1");

}
 ask_Info();

setInterval(ask_Info,60000);