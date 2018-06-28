//时间显示
function showTime(){
	let mydate=new Date;
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
	$(".bottomTime").html(html);
		$(".annotate").css("margin-top",($(".tem_hum_draw").height()+20)+"px");//注释栏
}

$(function(){
	$(document).ready(function(){
		showTime();
		get_floorInfo_db();
		click_lunbo();addtexttobox();
		$(".floorTabs #tab0").next().trigger('click');click_id=1;
		graph_overview('.overView_temp','.overView_humi');//概览曲线绘制
		setInterval(function(){showTime();},60000);//刷新时间显示
		notifyMSG();//报警消息
	});
});
$(function(){
	
	$("#tab0,#tab2").on('click',function(e){
		$('.annotate').css('display','none');
	});
	$("#tab1").on('click',function(e){
		$('.annotate').css('display','block');
	});

	//给主显示部分添加双击事件增加节点
	$(".tem_hum_draw").dblclick(function(event){
		sensorStyle(event);
		
	});
}); 
function tabClick(index){
	click_id=index+1;
	if(index==2 ||index==0){
				$('.annotate').css('display','none');
			}else{$('.annotate').css('display','block');}
}
var click_id=0;var lunbo_timer;var if_timer_clear=0;
function click_lunbo(){
	lunbo_timer=setInterval(function(){
		console.log("此时的click_id"+click_id);

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
	},15000);
}