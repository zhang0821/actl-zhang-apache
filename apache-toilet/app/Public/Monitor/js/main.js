
var showTime=function()
{
	let getTime=new Date();
	let time={
		year:getTime.getFullYear()+'年',
		month:getTime.getMonth()+1+'月',
		day:getTime.getDate()+'日&nbsp',
		week:['星期日','星期一','星期二','星期三','星期四','星期五','星期六'].slice((getTime.getDay()),(getTime.getDay()+1)),
		hour:(getTime.getHours()<10?'0'+getTime.getHours():getTime.getHours())+':',
		minute:(getTime.getMinutes()<10?'0'+getTime.getMinutes():getTime.getMinutes())+':',
		seconds:(getTime.getSeconds()<10?'0'+getTime.getSeconds():getTime.getSeconds())
	}
	let showTime=time.year+time.month+time.day+time.week+time.hour+time.minute+time.seconds;
	document.getElementById("time").innerHTML=showTime;
	//console.log(showTime);
}
var warnInfo=['hahahahahahhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh'];
var updateWarnInfo=function(info){
	let warnBox=document.getElementById("warnBox");
	let infoBox1=document.getElementById("infoBox1");
	let infoBox2=document.getElementById("infoBox2");
	infoBox1.innerText=info;
	let n=200/infoBox1.offsetWidth;
	for(let i=0;i<n;i++){
		infoBox1.innerHTML+=infoBox1.innerHTML;
	}
	infoBox2.innerHTML=infoBox1.innerHTML;
	let conf={
		speed:'50',
		boxRolling:function(){
			(warnBox.scrollLeft>=infoBox2.offsetLeft)?(warnBox.scrollLeft-=infoBox1.offsetWidth):(warnBox.scrollLeft+=1);
		}
	}
	let timmer=setInterval(conf.boxRolling,conf.speed);
	warnBox.addEventListener('mouseenter',function(){
		clearInterval(timmer);
	});
	warnBox.addEventListener('mouseleave',function(){
		timmer=setInterval(conf.boxRolling,conf.speed);
	});
}
//setInterval(showTime,1000);
//updateWarnInfo(warnInfo);



var close=function() {
	console.log("进入关闭函数");
	var target=document.getElementById("detial");
	target.style.cssText='display:none;z-index:0;';
}
var bind_evt=function(){
	// var btn=document.getElementById("close");
	// btn.addEventListener("onclick",close(),false);
	document.getElementById("close").addEventListener("click", function(){
	    close();
	});
}

bind_evt();
//render_info(toilet_data);
