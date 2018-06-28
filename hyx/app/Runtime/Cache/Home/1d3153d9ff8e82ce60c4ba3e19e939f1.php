<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>hello monitor</title>
	<link rel="stylesheet" type="text/css" href="/apache-toilet/app/Public/Monitor/css/main.css">

	<script src="/apache-toilet/app/Public/Monitor/libs/jquery/dist/jquery.js"></script>
	<script type="text/javascript" src="/apache-toilet/app/Public/Monitor/js/controller.js" ></script>
	<script type="text/javascript" src="/apache-toilet/app/Public/Monitor/js/main.js" defer></script>
</head>
<body>
	<div class="wrap">
		<header>
			<p>智慧卫生间</p>
			<p>引导及监测系统</p>
		</header>
		<div class="main">
			<div class="title-map">
				监控区域地图导航
			</div>

			<div class="map-info" id="map">
				
				
			</div>
		</div>

		<!-- <script type="text/javascript">
			
			var myTarget=document.getElementById('map');
			var context=document.createDocumentFragment();
			for(let i=0;i<toilet_data.length;i++){
				var newNode=document.createElement('div');
				newNode.style.top=toilet_data[i].style.top;
				newNode.style.left=toilet_data[i].style.left;
				newNode.style.background=toilet_data[i].style.background;
				newNode.innerHTML=toilet_data[i].name;
				newNode.setAttribute('id',toilet_data[i].id);//newNode.id=
				newNode.onclick=function(e){
					console.log("哈哈啊"+e);
				}
				context.appendChild(newNode);
			}
			myTarget.appendChild(context);
		</script> -->
	</div>
	<footer>
		<div>
			<p>告警信息</p>
			<!--<div id="notifyBox" class="notifyBox"> warnBox -->
				<div id="warnBox" class="warnBox">
					<div id="infoBox1"></div>
					<div id="infoBox2"></div>
				</div>
		</div>
		<div>
			<p id="time"></p>

		</div>
	</footer>

	<div id="detial">
		<div id="title">
			<div id="location_title"></div>
			<div id="close" click='close()'></div>
		</div>
		<div class="context">
			<div>
				<table border="1">
					<caption>检测指标实时值</caption>
					<tr>
						<th>监测项</th>
						<th>男卫</th>
						<th>女卫</th>
					</tr>
					<tbody id="tbody">
						表单
					</tbody>
				</table>
			</div>
			<div>
				<div class="woman" id="woman">
					女
				</div>
				<div class="man" id="man">
					男
				</div>
			</div>
			
		</div>
	</div>

	
</body>
</html>