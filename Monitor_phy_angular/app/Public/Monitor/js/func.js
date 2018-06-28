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
		var len=infoBox.length;
		if(1<len<4){
			infoBox.push(infoBox[0]);
		}
	},3000);
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