function slideBarClick(e,state){
	var eParent = e.target.parentNode;
	var typeName=e.target.textContent;
	if(state=="show"){
		eParent.style.background="#333";
		if(typeName=='门禁' || typeName=='烟雾' ){
			$(".navIcon").css("margin-top",(Math.round($(eParent).height()/2)-12)+"px");
			var width=Math.round($(".typeBox").width()*92/100);
			eParent.style.transition="-webkit-transform 1000ms ease-out";
			eParent.style.webkitTransform="translateX("+width+"px)";
			if(typeName=='门禁'){
				doorInfo();
			}
			else{
				smokeInfo();
			}
		}
		else{
			if(typeName=='水浸'){
				waterInfo();
			}
			$(".navIcon_sec").css("margin-top",(Math.round($(eParent).height()/2)-38)+"px");
			var width=0-Math.round($(".typeBox").width()*92/100);
			eParent.style.transition="-webkit-transform 1000ms ease-out";
			eParent.style.webkitTransform="translateX("+width+"px)";
		}
	}
	if(state=="hidden"){
		typeName=$(e.target).next().text();
		if(typeName=='门禁' || typeName=='烟雾' ){
			var width=0-Math.round($(".typeBox").width()*1/100);
			eParent.style.transition="-webkit-transform 1000ms ease-out";
			eParent.style.webkitTransform="translateX("+width+"px)";
		}
		else{
			var width=Math.round($(".typeBox").width()*1/100);
			eParent.style.transition="-webkit-transform 1000ms ease-out";
			eParent.style.webkitTransform="translateX("+width+"px)";
		}
		eParent.style.background="";
	}
}
function tem_hum_box_style(){
}

function Box4Hid(){
	var width=Math.round($(".typeBox").width()*1/100);
	document.getElementById("Box4").style.transition="-webkit-transform 1000ms ease-out";
	document.getElementById("Box4").style.webkitTransform="translateX("+width+"px)";
	document.getElementById("Box4").style.background='';
}
var querryType='temp',querryDate=16;//历史记录查询时默认查询参数

function setQuerBox(state){
	querryDate=16;
	Box4Hid();//先隐藏起旁边的选择框,使中间温湿度框最大
	var address='';
	if (state=='querry') {
		address='#checkBox';
	}
	if (state=='setting') {
		address='.setBox';
	}	
	if (state=='reset') {
		address='.reset';
	}
	$(address).css('opacity','1').css('z-index','10')
		.css('height',$('.TemHumBoxMain').height())
		.css('width',$('.TemHumBoxMain').width()).css('left',($(window).width()-$('.TemHumBoxMain').width())/2)
		.css('top',$('.TemHumBox').position().top);
	if (state=='setting') {
		querryAdminInfo();//显示联系人信息
	}	
	//$('.TemHumBoxMain').css('display','none');//隐藏中间的温湿度展示框
}
function QuerSetClose(state){
	if (state=='querry') {
		$("#checkBox").css('opacity','0').css('z-index','-10');
	}
	if (state=='setting') {
		postAdminInfo();//提交配置信息
		querryAdminInfo();
		// $(".setBox").css('opacity','0').css('z-index','-10');
		
	}
	if(state=='cancelSet'){
		$(".setBox").css('opacity','0').css('z-index','-10');
	}
	//$('.TemHumBoxMain').css('display','block');
	Box4Hid();
}
function chooseTypeBox(roomIndex)
{
	$(".typeLiBox").css("visibility","visible");
	if(roomIndex==0)
	{
		$(".typeLiBox").css("z-index",1000);
		$(".typeLiBox").css("opacity",0.9);
	}
	if(roomIndex==1){
		var litext=$(".typeChooseBox").text();
		$(".typeChooseBox").html($(".typeLiBox").text());
		if($(".typeChooseBox").text()=='温度'){
			querryType='temp';
		}
		else{
			querryType='humi';
		}
		$(".typeLiBox").css("z-index",-1000);
		$(".typeLiBox").css("visibility","hidden");
		$(".typeLiBox li").html(litext);
		get_history_db(querryDate,querryType);
	}
	
}
var X=0,Y=0,X_insert=0,Y_insert=0;
var SsInfo_timer;//暂时停止刷新信息页面
function sensorStyle(event){
	clearInterval(SsInfo_timer);
	X=event.offsetX;
	Y=event.offsetY;
	var parent_box_height=$(".TemHumBoxMain").height();
	var parent_box_width=$(".TemHumBoxMain").width();

	console.log("坐标值x是"+X+"坐标值Y是："+Y+"父元素盒子宽是："+parent_box_width+"父元素盒子高是："+parent_box_height);

	X_insert=Math.round(X/parent_box_width*10000)/10000;
	Y_insert=Math.round(Y/parent_box_height*10000)/10000;
	console.log("百分比x是"+X_insert+"百分比Y是："+Y_insert);
	newSs(X,Y,X_insert,Y_insert);
	$(".sensor").css("display","block").css("z-index",'100');
	
}
function newSs(x,y,x_insert,y_insert){
	var html='<div class="tempSs" style="position: absolute;top: '+(y-15)+'px;left:'+(x-15)+'px;background: #ccc;width: 30px;height: 30px;border-radius: 50% 50%;"></div>';
	$(".tem_hum_draw").append(html);
}
function addSsConfrm(){//确认添加
	$(".sensor").css("display","none");
	$(".tempSs").remove();
	getAddSsInfo(X_insert,Y_insert);//获取填入的信息
}
function addSsCancle(){//取消添加
	$(".sensor").css("display","none");
	$(".tempSs").remove();
}