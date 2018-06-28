<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html ng-app="monitorApp">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport"   content="height = [pixel_value | device-height] ,width = [pixel_value | device-width ] ,   
	initial-scale = float_value ,   
	minimum-scale = float_value ,   
	maximum-scale = float_value ,   
	user-scalable = [yes | no] ,   
	target-densitydpi = [dpi_value | device-dpi | high-dpi | medium-dpi | low-dpi] " />

<link rel="stylesheet" href="/Monitor_phy_angular_2/app/Public/Monitor/css/showSys.css" type="text/css" />
<link rel="shortcut icon" href="/Monitor_phy_angular_2/app/Public/Monitor/img/title.ico" type="image/x-icon" />



<!-- angular js插件 -->
<script src="/Monitor_phy_angular_2/app/Home/View/Index/framework/1.3.0.14/angular.js"></script>
<script src="/Monitor_phy_angular_2/app/Home/View/Index/framework/1.3.0.14/angular-route.js"></script>
<script src="/Monitor_phy_angular_2/app/Home/View/Index/framework/1.3.0.14/angular-animate.js"></script>


<script src="/Monitor_phy_angular_2/app/Public/Monitor/js/controllers.js"></script>
<script type="text/javascript" src="/Monitor_phy_angular_2/app/Public/Monitor/js/jquery.min.js"></script>
<script type="text/javascript" src="/Monitor_phy_angular_2/app/Public/Monitor/js/highcharts.js"></script>     
<script type="text/javascript" src="/Monitor_phy_angular_2/app/Public/Monitor/js/func.js"></script>
<script type="text/javascript" src="/Monitor_phy_angular_2/app/Public/Monitor/js/curve.js"></script>
<script type="text/javascript" src="/Monitor_phy_angular_2/app/Public/Monitor/js/style.js"></script>
<script type="text/javascript" src="/Monitor_phy_angular_2/app/Public/Monitor/js/showSysMain.js"></script>

<title>LoRa环境监测-物理学院</title>
<NOSCRIPT><iframe src="/Monitor_phy_angular_2/app/Home/View/Index/index.html"></iframe></NOSCRIPT>
</head>
<body>
	<div class="topBar">
		<!-- <canvas id="myTopBar" style="position: absolute;top:0;left: 0;"></canvas> -->
		 
		<div class="title">
			<!-- -->
			<div class="logoBar">
				<div class="logo">
				
				</div>
			</div>
			<div class="textBar" >
				<div class="titleText">
					环境监测系统&nbsp&nbsp&nbsp&nbsp
				</div>
				<div class="titleMini">
					&nbsp华中师范大学现代通信技术实验室
				</div>
				<audio src="/Monitor_phy_angular_2/app/Public/Monitor/music/fire.mp3" controls="controls"  id="music"  loop="loop" hidden="hidden">
				</audio>

			</div>
				

		</div> 
	</div>

	<div class="TemHumBox" >
		<div class="TemHumBoxMain" id="TemHumBoxMain">
			<!-- 选项卡 楼层切换 -->
			<ul class="floorTabs" >

				<li>
					<input type="radio" name="tabs" id="tab0" checked="checked" class="floorTab" onclick="tabClick(0)"/>
					<label for="tab0">曲线概览</label>
					<div id="tab-floor-0" class="tab-floor overview">
						<div class="overView_temp" style="width: 100%;height: 49%;margin-top:10px;float: left;">
							
						</div>
						<div class="overView_humi" style="width: 100%;height: 50%;float: left;margin-top:5px;">
							
						</div>
					</div>
				</li>

				<li>
					<input type="radio" name="tabs" id="tab1" class="floorTab" onclick="tabClick(1)"/>
					<label for="tab1">视图概览</label>
					<div id="tab-floor-1" class="tab-floor tem_hum_draw" ng-controller="sensorShow">
						<div ng-repeat="ss in sensors1 track by $index"  ng-class="{'0':'style_warn','1':'style_temHum','2':'style_smoke','3':'style_door','4':'style_water','5':'style_off','6':'star-five'}[{{ss.type}}]" ng-style="{'left':'{{ss.posx}}px','top':'{{ss.posy}}px'}" ng-click="toDo($event)" ><div ng-class="{'0':'box_show','1':'box_hidden'}[{{ss.value_hidden}}]">{{ss.temp_value}}<br>{{ss.humi_value}}</div>
			        	</div>
					</div>
				</li>
				<li>
					<input type="radio" name="tabs" id="tab8" class="floorTab" onclick="tabClick(2)"/>
					<label for="tab8">信息列表</label>
					<div id="tab-floor-8" class="tab-floor" style="overflow-y: auto;">	
						<table style="width: 100%;height:auto;font-family: '微软雅黑';">
							<caption style="font-size: 20px;border-bottom: 1px solid #fff;">
								监控房间实时信息汇总表
							</caption>
							<tr style="width:100%;height:30px;">
								<td>区域</td>
								<td>房间编号</td>
								<td>平均温度(℃)</td>
								<td>平均湿度(%Rh)</td>
								<td>烟雾报警器状态</td>
								<td>水浸传感器状态</td>
								<td>门禁传感器状态</td>
							</tr>
							<tbody id="info_tbody" ng-controller="tableBind">
								<tr ng-repeat="sInfo in SSinfo track by $index" ng-class="{'0':'warn','1':'normal','2':'offline'}[{{sInfo.ifWarn}}]">
									<td>{{sInfo.floor_name}}</td>
									<td>{{sInfo.room_id}}</td>
									<td>{{sInfo.temp_value}}</td>
									<td>{{sInfo.humi_value}}</td>
									<td>{{sInfo.smoke}}</td>
									<td>{{sInfo.water}}</td>
									<td>{{sInfo.door}}</td>
								</tr>							
						</tbody>						
						</table>
					</div>

				</li>

			</ul>

			<!-- 图标注释字段 -->
			<div class="annotate">
				<!-- <li class="annotate_tem_hum"><div></div><p>温湿度节点</p></li>
				<li class="annotate_door"><div></div><p>门禁节点</p></li>
				<li class="annotate_water"><div></div><p>水浸节点</p></li>
				<li class="annotate_smoke"><div></div><p>烟雾节点</p></li>
				<li class="annotate_tem_hum"><div></div><p>离线节点</p></li>
				<li class="annotate_abnormal"><div></div><p>异常节点</p></li> -->
			</div>
		</div>
	</div>

	<div class="notifyBar">
		<div class="notifyLogo">
			<!-- <canvas id="myNotify" style="width: 100%;height: 100%;"></canvas> -->
			<p>报警信息</p>
		</div>
		<div class="notifyBox" id="notifyBox">

		</div>
		<div class="bottomTime">
					
		</div>
	</div>
	
		<div id="checkBox" >
		<div class="checkBoxTop" >
			<a>一周内历史记录查询</a>
			
			<div class="closeBTN" onclick="QuerSetClose('querry')">
				<a>+</a>
			</div>
			
			<div id="hisDateBox" onclick="chooseHisDateBox(0)">
				今天
			</div>

			<div class="typeChooseBox" onclick="chooseTypeBox(0)" >温度</div>


		</div>
		
		<div class="dateLiBox">
			<li onclick="chooseHisDateBox(8)">
			今天
			</li>
			<li onclick="chooseHisDateBox(1)">
			前1天
			</li>
			<li onclick="chooseHisDateBox(2)">
			前2天
			</li>
			<li onclick="chooseHisDateBox(3)">
			前3天
			</li>
			<li onclick="chooseHisDateBox(4)">
			前4天
			</li>
			<li onclick="chooseHisDateBox(5)">
			前5天
			</li>
			<li onclick="chooseHisDateBox(6)">
			前6天
			</li>
			<li onclick="chooseHisDateBox(7)">
			前7天
			</li>
		</div>
		
		<div class="typeLiBox">
			<li onclick="chooseTypeBox(1)">湿度</li>
		</div>


		<div id="hisDataContainer" >
		

		</div>
		
	</div>
	<div class="setBox">	
	<ul class="tabs" >
		<li>
			<input type="radio" name="tabs" id="tabTher1" checked="checked" class="bigTab" />
			<label for="tabTher1">阈值配置</label>
			<div id="tab-content-threshold" class="tab-content">
				<div class="newpage setting">
					<div class="roomBox roomBoxAll">
						<div style="margin-left: 35%;">
							房间配置
							<!-- <input type="textbox" id="room1" placeholder="例如：1" /> -->
						</div>
						<div></div>
						<div>
							温度阈值
							<input type="textbox" id="SettempMax" style="width:100px;" />高
							<input type="textbox" id="SettempMin" style="width:100px;" />低
						</div>
						
						<div>
							湿度阈值
							<input type="textbox" id="SethumiMax" style="width:100px;" />高
							<input type="textbox" id="SethumiMin" style="width:100px;"/>低
						</div>
						<div>
							
						</div>
						<div>
							<button onclick="postSetThreshInfo('all')">应用到所有房间</button>
						</div>
					</div>

					<div class="roomBox roomBoxSingle">
						<div style="margin-left: 35%;">
							单独配置
							<!-- <input type="textbox" id="room1" placeholder="例如：1" /> -->
						</div>
						<div>
							房间编号
							<input type="textbox" id="room_id" />
						</div>
						<div>
							温度阈值
							<input type="textbox" id="SettempMaxSingle" style="width:100px;"/>高
							<input type="textbox" id="SettempMinSingle" style="width:100px;" />低
						</div>
						
						<div>
							湿度阈值
							<input type="textbox" id="SethumiMaxSingle" style="width:100px;"/>高
							<input type="textbox" id="SethumiMinSingle" style="width:100px;"/>低
						</div>
						<div>
							<button onclick="postSetThreshInfo('single')">配置下一房间</button>
						</div>
					</div>
				</div>
			</div>
		</li>

		<li>
			<input type="radio" name="tabs" id="tabTher2" class="bigTab" />
			<label for="tabTher2">联系人</label>
			<div id="tab-content-contact" class="tab-content" " >	
				<div class="newpage contact">
						<div class="currentContacter" >
						<!-- 在进入配置页面时就出发请求联系人信息的函数 -->
							<p>当<br>前<br>联<br>系<br>人</p>
							<div class="currentAdmin">
								

							</div>
							<div class="delAdmin">
								删除联系人&nbsp;&nbsp;
								<input type="textbox" id="delName" placeholder="姓名" style="width: 80px;margin-top: 10px;"><br>
								<button  onclick="postDelAdminInfo()">
								确认删除
								</button>
							</div>
						</div>

						<div class="addNew" >
							<p>添<br>加<br>联<br>系<br>人</p>
							<div class="fillNew">
								姓名
								<input type="textbox" id="nameNew" style="width:70px;margin-right:30px;" />
								电话
								<input type="textbox" id="phoneNew" style="margin-right:30px;" />
								邮箱
								<input type="textbox" id="emailNew" />
							</div>
							<div class="newBTN">
								<button onclick="postAdminInfo()">
									next
								</button>
							</div>
					
						</div>
				</div>
			</div>
		</li>
	</ul>
		<!--提交-->
	<div class="submitBox" >
		<div class="subButton1" onclick="QuerSetClose('setting')">
			提交配置
		</div>
		<div class="subButton2" onclick="QuerSetClose('cancelSet')">
			关闭
		</div>
		<!-- <div class="setCloseBtn" onclick="QuerSetClose('setting')">
			<a >+</a>	
		</div> -->
	</div>
	
</div>

		<!-- 增加节点弹出框 -->
		<div class="sensor">
			<div class="type">
				节点类型
				<li><input type="radio" name="radio" value="tem_hum" checked="checked">温湿度</li>
				<li><input type="radio" name="radio" value="smoke" >烟雾</li>
				<li><input type="radio" name="radio" value="water" >水浸</li>
				<li><input type="radio" name="radio" value="door" >门禁</li>
			</div>
			<div class="paraConfig">
				<li>
					节点EUI&nbsp
					<input type="textbox" id="dev_eui" style="width:50%;height: 20px;font-size: 20px;"/>
				</li>
				<li>
					楼层编号
					<input type="textbox" id="floor_id" style="width:100px;" />
					房间号
					<input type="textbox" id="my_room_id" style="width:100px;" />
				</li>

				<li>
					温度阈值
					<input type="textbox" id="tem_max" style="width:100px;"/>
					高
					<input type="textbox" id="tem_min" style="width:100px;"/>
					低
				</li>
				
				<li>
					湿度阈值
					<input type="textbox" id="hum_max" style="width:100px;" />
					高
					<input type="textbox" id="hum_min" style="width:100px;" />
					低
				</li>
				
			</div>
			<div class="ifConfirm">
				<button onclick="addSsConfrm()">确定</button>
				<button onclick="addSsCancle()">取消</button>
			</div>
		</div>
		
		<!-- 曲线图大图绘制 -->
		<div class="graph">
			<div class="closeBTN" onclick="graphClose()">
				<a>+</a>
			</div>
			<div class="graphBox" >
				111
			</div>
		</div>

	 
</body>
</html>