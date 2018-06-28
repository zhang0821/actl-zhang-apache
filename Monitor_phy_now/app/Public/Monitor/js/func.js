function smokeInfo(){
	get_SsType_warn('smoke');
}
function waterInfo(){
	get_SsType_warn('water');
}
function doorInfo(){
	get_SsType_warn('door');
}
/***获取添加节点的配置信息并存入数据库*****/
var ifRefreshTemHumFlag=0;
function getAddSsInfo(x,y){
	var typeSs=$(".type input[type='radio']:checked").val();
	var room_id=$("#my_room_id").val().toLowerCase();
	var dev_eui=$("#dev_eui").val().toLowerCase();
	var tempMax=$("#tem_max").val();
	var tempMin=$("#tem_min").val();
	var humiMax=$("#hum_max").val();
	var humiMin=$("#hum_min").val();
	var floor_id=($("#floor_id").val()-1);
	alert(dev_eui+"楼层编号"+floor_id+"/房间编号"+room_id+"/"+typeSs+"/"+tempMax+"/"+tempMin+"/"+humiMax+"/"+humiMin+"/"+x+"/"+y);
	send_ssInfo_db(dev_eui,room_id,floor_id,typeSs,tempMax,tempMin,humiMax,humiMin,x,y);
	// while(1){
	// 	if(ifRefreshTemHumFlag==1){
	// 		ifRefreshTemHumFlag=0;
	// 		break;
	// 	}
	// }//应该这个时候取消刷新温湿度界面的定时器
	get_SsIfon_db();//刷新节点的展示界面
}
/********************************画图曲线*******/

/*************************资讯通知栏**********************/
var infoBox=[];//内容长度要大于容器长度！
function notifyMSG(){
	$('.notifyBox').empty();
	var html='<div id="notifyBox1">'+infoBox+'</div><div id="notifyBox2"></div>';
	$('.notifyBox').append(html);
	var notifyBox =document.getElementById("notifyBox");
	var notifyBox1 = document.getElementById("notifyBox1");
	var notifyBox2 = document.getElementById("notifyBox2");
	var speed=50;                                             //滚动速度值，值越大速度越慢#F4EDE7
	var nnn=200/notifyBox1.offsetWidth;
	for(i=0;i<nnn;i++){notifyBox1.innerHTML+=notifyBox1.innerHTML;}
	notifyBox2.innerHTML = notifyBox1.innerHTML;         //克隆warningtext2为warningtext
	function BoxRolling(){
		if(notifyBox.scrollLeft >= notifyBox2.offsetLeft){ //当滚动条隐藏的长度大于div1的宽度
			notifyBox.scrollLeft-=notifyBox1.offsetWidth;
		}
		else {
			notifyBox.scrollLeft+=1; //每次滚动条往右移动1px；
		}
	}
	var Mytimer = setInterval(BoxRolling,speed);              //设置定时器
	$(".notifyBox").mouseenter(function (){clearInterval(Mytimer);}).mouseleave(function(){Mytimer = setInterval(BoxRolling,speed);});
}
function addtexttobox(){
	setInterval(function() {
/**/
		var len=infoBox.length;
		if(1<len<4){
for(var i=0;i<len;i++)
{
//var str=infoBox[i];
//str.replace(/[^\u4e00-\u9fa5]/gi,"");
	infoBox.push(infoBox[i]);
}
			
		}

		notifyMSG();
	},10000);

	/*SsInfo_timer=setInterval(function() {
		get_SsIfon_db();
	},10000);*/
}
/**********************************联系人配置*************/
//验证手机号正则表达式
function checkMobil(str) {
    var re = /^1\d{10}$/;
    if (re.test(str)) {
        return 1;
    } 
    else{
        alert("请输入正确手机号！");
        return 0;
    }
}
//验证邮箱
function checkEmail(str){  
    var reg=/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/ ;
    if(reg.test(str)){ 
    	return 1;   
        // console.log("邮箱正确！");  
    }  
    else{
    	alert("请输入正确邮箱！");
    	return 0;  
    }  
} 
/**********************当前联系人信息获取并显示*****/
function querryAdminInfo(){
	$.ajax({
		type: 'POST',
		url: "../app/index.php/Home/Info/adminInfoToWeb",
		dataType: "json",
		success: function(data){
			if(data!=0){
				var html=''; 
				for(var i=0;i<data.length;i++){
					html+='<div>姓名：'+data[i].name+'  电话：'+data[i].tel+' 邮箱：'+data[i].email+'</div>';
				}
			}
			else{
				var html='<div>无联系人信息</div>'
			}
			$(".currentAdmin").empty().append(html);
		}	
	});
}
function postAdminInfo(){
	var name=document.getElementById("nameNew").value;
	var tel=document.getElementById("phoneNew").value;
	if (checkMobil(tel)==0) {
		return 0;
	}
	var email=document.getElementById("emailNew").value;
	if (checkEmail(email)==0) {
		return 0;
	}
	alert(name+tel+email);
	$.ajax({
		type: 'POST',
		url: "../app/index.php/Home/Info/postAdminInfo",
		data:{"name":name,"tel":tel,"email":email},
		dataType: "json",
		success: function(data){
			if(data==2){
				alert("新增用户"+name+"成功！");
			}
			if(data==1){
				alert("用户"+name+"已存在！");
			}
			if(data==0){
				alert("新增用户失败！");
			}
		}	
	});
	querryAdminInfo();
}
function postDelAdminInfo(){
	var name=document.getElementById("delName").value;
	$.ajax({
		type: 'POST',
		url: "../app/index.php/Home/Info/delAdminInfo",
		data:{"name":name},
		dataType: "json",
		success: function(data){
			if(data==2){
				alert("删除用户"+name+"成功！");
			}
			if(data==1){
				alert("用户"+name+"本就不存在！");
			}
			if(data==0){
				alert("删除用户"+name+"失败！");
			}
		}	
	});
	querryAdminInfo();
}
/**************************获取配置信息的值并发送到数据库保存*********/
function postSetThreshInfo(choice){
	var setData=[];
	if(choice=='all'){
		setData.push('all');//房间号为空
		$(".roomBoxAll input[type=textbox]").each(function(){
			if($(this).val()!=''){
				setData.push($(this).val());
				$(this).val("");
			}
		});
	}
	if(choice=='single'){
		$(".roomBoxSingle input[type=textbox]").each(function(){
			if($(this).val()!=''){
				setData.push($(this).val());
				$(this).val("");
			}
		});
	}
	if(setData.length==5){
		alert(setData);
		$.ajax({
			type:'post',
			url:'../app/index.php/Home/Info/get_SetInfo_DB',
			dataType:'json',
			data:{'room_id':setData[0],'tempMax':setData[1],'tempMin':setData[2],'humiMax':setData[3],'humiMin':setData[4]},
			success:function(data){
				if(data){
					alert("房间"+setData[0]+"配置成功！");
				}
			}
		});
	}
	else{
		alert("不能为空！");
	}
}
/************************************与数据库交互操作***************/
//保存新增节点到数据库
function send_ssInfo_db(dev_eui,room_id,floor_id,typeSs,tempMax,tempMin,humiMax,humiMin,posX,posY){
	$.ajax({
		type:"post",
		url:"../app/index.php/Home/Info/get_send_ssInfo_DB",
		dataType:"json",
		data:{"dev_eui":dev_eui,"room_id":room_id,"floor_id":floor_id,"typeSs":typeSs,"tempMax":tempMax,"tempMin":tempMin,"humiMax":humiMax,"humiMin":humiMin,"posX":posX,"posY":posY},
		success:function(data){
			//请求超时时，也应该弹出添加失败
			if (data==0) {
				alert("添加失败！");
			}
			if (data==1) {
				alert("该节点已存在！");
			}
			if (data==2) {
				alert("添加成功！");
			}
			ifRefreshTemHumFlag=1;
		}
	});
}
//从数据库中读取节点消息
var ifStartGraph=0,graphRM_id,graphFL_id,firstFlag=1,tem_hum_value_array=[[],[],[]];//X轴坐标，温度，湿度
var music_warn_on=0;
function get_SsIfon_db(){
	//$("#music")[0].pause();
	$.ajax({
		type:"post",
		url:"../app/index.php/Home/Info/send_SsInfo_web",
		dataType:"json",
		success:function(mydata){
			//$("#music")[0].pause();
			console.log('成功从服务器请求道数据并暂停音乐1：');
			if(if_timer_clear==1)
			{
				click_lunbo();if_timer_clear=0;
			}
			var music_warn=0;
			var parent_box_height=$(".TemHumBoxMain").height();
			var parent_box_width=$(".TemHumBoxMain").width();			
			if (mydata) {	
				$(".tem_hum_draw").empty();
				infoBox=[];
				$("#info_tbody").append(' ');	
				var color;
				for(var j=1;j<9;j++){
					if($(".lable-red"+j).length>0){
						$(".lable-red"+j).removeAttr("style");
					}
					if($(".lable-gray"+j).length>0){
						$(".lable-gray"+j).removeAttr("style");
					}
				}

				
				for(var h=0;h<mydata.length;h++){
					var data=mydata[h];
					for(var i=0;i<data.length;i++){
						// var address="#tab-floor-"+(Number(data[i].floor_id)+1);//画的位置
						var address="#tab-floor-1";
						var room_name=(data[i].room_id).toUpperCase();
						if(data[i].room_id=='zxs'){
							room_name='自习室';
						}
						if(data[i].room_id=='pl'){
							room_name='漂流吧';
						}
						if(data[i].room_id=='lpd'){
							room_name='礼品店';
						}
						if(data[i].room_id=='yz9'){
							room_name='驿站-九号楼';
						}
						if(data[i].room_id=='yz6'){
							room_name='驿站-东六';
						}
						if(data[i].room_id=='dating'){
							room_name='一楼大厅';
						}
						
						var html_table='<tr class="F'+data[i].floor_id+'-'+data[i].room_id+'"><td>'+room_name+'</td>';

						if(data[i].online==0)//该节点离线
						{
							//该楼层选项卡变灰
							if($(".floorTabs li:eq("+(Number(data[i].floor_id)+1)+") label").hasClass("lable-gray"+(Number(data[i].floor_id)+1))){
								$(".lable-gray"+(Number(data[i].floor_id)+1)).css('background-color','#333');	
							}
							else{
								$(".floorTabs li:eq("+(Number(data[i].floor_id)+1)+") label").addClass("lable-gray"+(Number(data[i].floor_id)+1));
								$(".lable-gray"+(Number(data[i].floor_id)+1)).css('background-color','#333');
							}
							infoBox.push(data[i].floor_name+' '+room_name+' '+'有传感器离线了 ');
							var html='<div style=font-family:myfont;position:absolute;top:'
										+(Math.round(parent_box_height*data[i].posy)-15)+'px;left:'+(Math.round(parent_box_width*data[i].posx)-15)+'px;background:#333;width:30px;height:30px;border-radius:50% 50%;"></div>';
								$(address).append(html);
							if($('.F'+data[i].floor_id+'-'+data[i].room_id).length>0){
								if(data[i].type=='tem_hum' && !($('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(2).val()>(-100))){
									$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(1).html("--");
									$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(2).html("--");
								}
								if(data[i].type=='smoke'){
									$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(3).html("存在离线节点");
								}
								if(data[i].type=='door'){
									$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(5).html("离线");
								}
							}
							else{
								html_table+='<td>存在离线节点</td><td>存在离线节点</td><td>存在离线节点</td><td>--</td><td>--</td></tr>';
								$("#info_tbody").append(html_table);	
							}

						}
						else{
							if (data[i].type=='tem_hum') {
								color='background:#446F9E';//温度如果超过阈值，变红
								var content=data[i].temp_value+'<br>'+data[i].humi_value;
								if(data[i].status==1){
										var html='<div class="'+data[i].room_id+
										' blink" style=font-family:myfont;position:absolute;top:'
										+(Math.round(parent_box_height*data[i].posy)-20)+'px;left:'+(Math.round(parent_box_width*data[i].posx)-30)+'px;'
										+color+';width:60px;height:40px;border-radius:15px;cursor: pointer;>'+content+'</div>';
										$(address).append(html);
									}
								else{
									color='background:#DC210F';
									
									var html='<div class="'+data[i].room_id+' warnBlink" style="font-family:myfont;position:absolute;top:'
									+(Math.round(parent_box_height*data[i].posy)-30)+'px;left:'+(Math.round(parent_box_width*data[i].posx)-30)+'px;'+color+
									';width: 60px;height: 60px;border-radius: 50% 50%;cursor: pointer;line-height:28px;" >'+content+'</div>';
									$(address).append(html);
									
									infoBox.push(data[i].floor_name+' '+room_name+' '+'有温湿度传感器报警 ');
									
									if($(".floorTabs li:eq("+(Number(data[i].floor_id)+1)+") label").hasClass("lable-red"+(Number(data[i].floor_id)+1))){
										$(".lable-red"+(Number(data[i].floor_id)+1)).css('background-color','red');	
									}
									else{
										$(".floorTabs li:eq("+(Number(data[i].floor_id)+1)+") label").addClass("lable-red"+(Number(data[i].floor_id)+1));
										$(".lable-red"+(Number(data[i].floor_id)+1)).css('background-color','red');
									}
									
								}
							}
							else{
								if(data[i].status!=0 || data[i].type=='door'){ //正常情况
									var style=';width: 30px;height: 30px;border-radius: 50% 50%;"></div>';
									switch(data[i].type){
											case 'smoke':
												color='width: 0;height: 0;border-left: 14px solid transparent;border-right: 14px solid transparent;border-bottom: 24px solid rgba(214,190,46,0.6)';
												style=';"></div>';
												break;
											case 'door':
												if(data[i].status==1){
													color='background:#8A5B47';
												}
												else{
													color='background:#fff';
												}
												style=';width: 30px;height: 30px;"></div>';
												break;
											case 'water':
												color='background: rgba(0,86,97,.9)';
												break;
											default:
												color='background:#000';
									}
									var html='<div  class="blink" style="position:absolute;top: '+(Math.round(parent_box_height*data[i].posy)-15)+'px;left:'+(Math.round(parent_box_width*data[i].posx)-15)+'px;'+color+
												style;
									$(address).append(html);
								}
								else{
										var showTest='';
										color='background:#DC210F';
										var warnText;
										if($(".floorTabs li:eq("+(Number(data[i].floor_id)+1)+") label").hasClass("lable-gray"+(Number(data[i].floor_id)+1))){
											$(".lable-gray"+(Number(data[i].floor_id)+1)).removeAttr("style");
										}
										if($(".floorTabs li:eq("+(Number(data[i].floor_id)+1)+") label").hasClass("lable-red"+(Number(data[i].floor_id)+1))){
											$(".lable-red"+(Number(data[i].floor_id)+1)).css('background-color','red');	
										}
										else{
											$(".floorTabs li:eq("+(Number(data[i].floor_id)+1)+") label").addClass("lable-red"+(Number(data[i].floor_id)+1));
											$(".lable-red"+(Number(data[i].floor_id)+1)).css('background-color','red');
										}	
										switch(data[i].type){
											case 'smoke':
												warnText='烟雾';
												showTest='烟';
												$(".floorTabs #tab"+(Number(data[i].floor_id)+1)).next().trigger('click');
												if(if_timer_clear==0){clearInterval(lunbo_timer);}if_timer_clear=1;//如果烟雾传感器报警，页面停留在当前报警页面
												break;
											 // case 'door':
												// color='background:#fff';
												// // warnText='门禁';
												// // showTest='门';
												 // break;
											case 'water':
												warnText='水浸';
												showTest='水';
												break;
											default:
												var warnText='';
										}
									infoBox.push(data[i].floor_name+' '+room_name+' '+'有'+warnText+'传感器报警 ');//启动报警
									var html='<div class="warnBlink star-five" style="text-align:center;position:absolute;top: '+(Math.round(parent_box_height*data[i].posy)-50)+'px;left:'+(Math.round(parent_box_width*data[i].posx)-40)+'px;'+color+
									'">'+showTest+'</div>';
									$(address).append(html);
								}	
							}
							if($('.F'+data[i].floor_id+'-'+data[i].room_id).length>0){
								if(data[i].type=='tem_hum'){
									if(data[i].temp_value!=null){
										$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(1).html(data[i].temp_value);
										$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(2).html(data[i].humi_value);
									}
								}
								if(data[i].type=='smoke'){
									if(data[i].status==0){
										$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(3).html("报警");
										music_warn=1;
									}
									else{
										$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(3).html("正常");
									}
								}
								if(data[i].type=='door'){
									if(data[i].status==0){
										$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(5).html("开");
									}
									else{
										$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(5).html("关");
									}
								}
								
							}
							else{
								// if(data[i].type=='smoke' && data[i].status==0)
								// {
									// music_warn=1;
								// }
								// if((data[i].type=='smoke' && data[i].status==1) || data[i].type=='tem_hum'){
									// html_table+='<td>'+data[i].temp_value+'</td><td>'+data[i].humi_value+'</td><td>正常</td><td>--</td><td>--</td></tr>';
								// }
								// else{
									// html_table+='<td>'+data[i].temp_value+'</td><td>'+data[i].humi_value+'</td><td>报警</td><td>--</td><td>--</td></tr>';
								// }
								
								// $("#info_tbody").append(html_table);	
								if(data[i].type=='tem_hum'){
									if(data[i].temp_value!=null){
										html_table+='<td>'+data[i].temp_value+'</td><td>'+data[i].humi_value+'</td><td>--</td><td>--</td><td>--</td></tr>';
				
									}
								}
								else{
									html_table+='<td>离线</td><td>离线</td><td>--</td><td>--</td><td>--</td></tr>';
								}
								$("#info_tbody").append(html_table);	
								// if(data[i].type=='tem_hum'){
									// if(data[i].temp_value!=null){
										// $('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(1).html(data[i].temp_value);
										// $('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(2).html(data[i].humi_value);
									// }
									// else{
										// $('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(1).html('存在离线节点');
										// $('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(2).html('存在离线节点');
									// }
								// }
								if(data[i].type=='smoke'){
									if(data[i].status==0){
										$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(3).html("报警");
										music_warn=1;
									}
									else{
										$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(3).html("正常");
									}
								}
								if(data[i].type=='door'){
									if(data[i].status==0){
										$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(5).html("开");
									}
									else{
										$('.F'+data[i].floor_id+'-'+data[i].room_id).find("td").eq(5).html("关");
									}
								}
								
							}

						}		
					}
				}
				firstFlag=1;
				setInterval(function() {warnBlink()},400);
				
			}
			console.log('音乐是否要响的状态标志位：'+music_warn);
			//如果该次中有需要报警的烟雾，则播放音乐
			if(music_warn==1){
				if(music_warn_on==0)
				{
					$("#music")[0].play();
				}
				music_warn=0;
				music_warn_on=1;
				//$(".textBar").append('<audio src="Public/Monitor/music/fire.mp3" controls="controls" autoplay id="music"  loop="loop" hidden="hidden" ></audio>');
			}
			else{
				if(music_warn_on==1)
				{
					$("#music")[0].pause();					
				}
				music_warn_on=0;
			}
		}
	});
}
function warnBlink(){//报警，节点闪烁
	if($(".warnBlink")){
		$(".warnBlink").fadeOut(250).fadeIn(250);
	}
	if($(".blink")){
		$(".blink").fadeOut(3000).fadeIn(3000);
	}
	if($(".fontType")){
		$(".fontType").css('font-family','myfont');
	}
	// $(".logo").fadeOut(5000).fadeIn(500);
}
//从数据库请求各类节点报警信息
function get_SsType_warn(type){
	$.ajax({
		type:"post",
		url:"../app/index.php/Home/Info/send_Ss_warn",
		dataType:"json",
		data:{"type":type},
		success:function(data){
			var html='<h3>无</h3>';
			if (data) {
				// var monShow=((mon < 10) ? "0" : "") + mon;
				// var dayShow=((day < 10) ? "0" : "") + day;
				// var yearShow=year;
				html='';
				// var timeNow=yearShow+'-'+monShow+'-'+dayShow;
				// for(var i=0;i<data.length;i++)
				// { 
				// 	var timeDate=data[i].datetime.substr(data[i].datetime,data[i].datetime.indexOf(' '));
				// 	if(timeNow==timeDate){
				// 		html='';
				// 		var timeShow=data[i].datetime.substr(data[i].datetime.indexOf(' ')+1,5);
				// 		html+='<div>房间:'+data[i].room_id+'&nbsp时间:'+timeShow+'</div>';
				// 	}
				// }
				for(var i=0;i<data.length;i++)
				{
					var timeShow=data[i].datetime.substr(data[i].datetime.indexOf(' ')+1,5);
					html+='<div>'+(Number(data[i].floor_id)+1)+'楼&nbsp'+data[i].room_id+'房&nbsp异常时间:'+timeShow+'</div>';
				}
				// if(data.length>3){
				// 	$("."+type+"Box").css("width","12%").css("overflow-y","auto");
				// }
				
			}
			$("."+type+"Content").find("div").remove();
			$("."+type+"Content").find("h3").remove();
			$("."+type+"Content").append(html);
		}
	});
}
//从数据库获取历史数据
var tem_hum_history=[];
function get_history_db(his_date,type){
	$.ajax({
		type:'post',
		dataType:'json',
		url:'../app/index.php/Home/Info/send_history_web',
		data:{"his_date":his_date},
		success:function(data){
			if (data)
			{
				tem_hum_history=[];
				var floor_count=data.length;
				alert(floor_count);
				for(var i=0;i<floor_count;i++){
					tem_hum_history.push(data[i]);///用new array初始化一个X长度数组以后，如果后面对他再用push函数传入Y个值，
												///则数组的长度x+y,故用了new之后，要用[0]=？这种形式赋值

				}
				graphHisCurve(his_date,type);//画图曲线
			}
			else{
				var innertext='<div style="text-align:center;color: #fff;float:left;width:100%;height:200px;margin-top:200px;font: 30px "微软雅黑";">数据库没有这一天的数据哦~</div>';
				$('#hisDataContainer').html(innertext);
			}
		}
	});
	
}