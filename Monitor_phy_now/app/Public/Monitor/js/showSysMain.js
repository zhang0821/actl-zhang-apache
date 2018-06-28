//标题栏的渐变背景色
function drawCanvas(){
	$("#myTopBar").css("width",$(window).width()).css("height",$(".topBar").height())
	.css("z-index","-100");
	var title=document.getElementById("myTopBar").getContext("2d");
	var grd=title.createRadialGradient(240,50,5,90,60,220);
	grd.addColorStop(0,'rgb(69,21,79)');
	grd.addColorStop(1,'#000');
	title.fillStyle=grd;
	title.beginPath();
	title.fillRect(0,0,$(".topBar").width(),$(".topBar").height());
}
//时间显示
function showTime(){
	let mydate=new Date;
	// var weekday=["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];
	var day=mydate.getDate();
	var nday=mydate.getDay();
	var mon=mydate.getMonth()+1;
	var year=mydate.getFullYear();
	// var week=weekday[nday];
	var hours=mydate.getHours();
	var minutes=mydate.getMinutes();
	var hourShow=((hours < 10) ? "0" : "") + hours;
	var minuteShow=((minutes < 10) ? "0" : "") + minutes;
	var html=year+"."+mon+"."+day+ '&nbsp;&nbsp;' +hourShow+"'"+minuteShow;
	// var html=year+"."+mon+"."+day+ '&nbsp;&nbsp;' +hourShow+"`"+minuteShow+"&nbsp; "+week;
	$(".bottomTime").html(html);
	$(".annotate").css("margin-top",($(".tem_hum_draw").height()+20)+"px");//注释栏
}

$(function(){
	$(document).ready(function(){
		showTime();
		sensor_types();
		get_floorInfo_db();
		click_lunbo();
		$(".floorTabs #tab0").next().trigger('click');click_id=1;
		graph_overview('.overView_temp','.overView_humi');//概览曲线绘制
		get_SsIfon_db();
		setInterval(function(){showTime();},60000);//刷新时间显示
		setInterval(function(){get_SsIfon_db();},10000);
		notifyMSG();//报警消息
		addtexttobox();
	});
});
$(function(){
	$(".typeBox").on('click','a',function(e){
		slideBarClick(e,"show");
	});
	$(".navIcon").on('click',function(e){
		slideBarClick(e,"hidden");
	});
	$(".navIcon_sec").on('click',function(e){
		slideBarClick(e,"hidden");
	});

	$("#tab0,#tab8").on('click',function(e){
		$('.annotate').css('display','none');
	});
	$("#tab1,#tab2,#tab3,#tab4,#tab5,#tab6,#tab7").on('click',function(e){
		$('.annotate').css('display','block');
	});

	//给主显示部分添加双击事件增加节点
	$(".tem_hum_draw").dblclick(function(event){
		sensorStyle(event);
		
	});
}); 

// function chooseHisDateBox(dataIndex)
// {
// 	querryDate=dataIndex;
// 	$(".dateLiBox").css("visibility","visible");
// 	if(dataIndex==0)
// 	{
// 	$(".dateLiBox").css("z-index",1000);
// 	$(".dateLiBox").css("opacity",0.7);
// 	}
// 	if(dataIndex!=0)
// 	{
// 		var html='前'+dataIndex+'天';
// 		if(dataIndex==8)
// 		{
// 			dataIndex=0;
// 			html='今天';
// 		}
// 		document.getElementById("hisDateBox").innerHTML=html;
// 		$(".dateLiBox").css("z-index",-1000);
// 		$(".dateLiBox").css("visibility","hidden");
// 		get_history_db(querryDate,querryType);
// 	}
// }

function sensor_types(){
	$.ajax({
		type: 'POST',
		url: "../app/index.php/Home/Info/sensor_type_search",
		dataType: "json",
		success: function(data){
			if(data!=0){
				var html='';
				for(var i=0;i<data.length;i++){
					if(data[i].type=='water'){
						html+='<li class="annotate_water"><div></div><p>水浸节点</p></li>';
					}
					if(data[i].type=='door'){
						html+='<li class="annotate_door"><div></div><p>门禁节点</p></li>';
					}
					if(data[i].type=='smoke'){
						html+='<li class="annotate_smoke"><div style="width: 0; height: 0;"></div><p>烟雾节点</p></li>';
					}
					if(data[i].type=='tem_hum'){
						html+='<li class="annotate_tem_hum"><div></div><p>温湿度节点</p></li>';
//html+='<li class="annotate_tem_hum"><div></div><p>温湿度节点<a style="font-size: 0.9em;color:rgba(68,111,158,0.9);">单击查看该房间温湿度曲线</a></p></li>';
					}
				}
				html+='<li class="annotate_abnormal"><div></div><p>异常节点</p></li><li class="annotate_offline"><div></div><p>离线节点</p></li>';
				$(".annotate").empty().append(html);
			}	
		}
	});
}
/*
function tabClick(index){
	click_id=index;
	if(click_id==8){
				$('.annotate').css('display','none');
			}
}
var click_id=0;var lunbo_timer;var if_timer_clear=0;
function click_lunbo(){
	lunbo_timer=setInterval(function(){
		for(var i=0;i<9;i++){
			if(i==click_id){	
				$(".floorTabs #tab"+click_id).next().trigger('click');
			}
			if(0==click_id || click_id==8){
				$('.annotate').css('display','none');
			}
			else{
				$('.annotate').css('display','block');
			}
		}
		click_id++;
		 if(click_id==2)//2,3,5楼现在无数据，先不轮播显示；
		 {
		 	click_id=8;
		 }
		// if(click_id==5){
		// 	click_id=6;
		// }
		//console.log("进入模拟点击事件");
		if(click_id>9){
			click_id=0;
		}
	},5000);
}*/

function tabClick(index){
	click_id=index+1;
	if(index==2 ||index==0){
				$('.annotate').css('display','none');
			}else{$('.annotate').css('display','block');}
}
var click_id=0;var lunbo_timer;var if_timer_clear=0;
function click_lunbo(){
	lunbo_timer=setInterval(function(){
		for(var i=1;i<4;i++){
			if(i==click_id){
				if(click_id==3){$(".floorTabs #tab8").next().trigger('click');}
				else{$(".floorTabs #tab"+(click_id-1)).next().trigger('click');console.log("此时的click_id"+click_id);}
			}
			if(click_id==2){
				$('.annotate').css('display','block');
			}
			else{
				$('.annotate').css('display','none');
			}
		}
		click_id++;
		if(click_id>3){
			click_id=1;
		}
	},30000);
}
