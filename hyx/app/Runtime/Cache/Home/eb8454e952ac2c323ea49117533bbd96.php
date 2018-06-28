<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<title>Temperature And Humidity</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="/HTTP-Zigbee/app/Public/protected/css/bootstrap.min.css" />
<link rel="stylesheet" href="/HTTP-Zigbee/app/Public/protected/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="/HTTP-Zigbee/app/Public/protected/css/matrix-style.css" />
<link rel="stylesheet" href="/HTTP-Zigbee/app/Public/protected/css/matrix-media.css" />
<link href="/HTTP-Zigbee/app/Public/protected/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="/HTTP-Zigbee/app/Public/protected/css/googlefonts.css" />
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a>Zigbee Monitor Network</a></h1>
</div>
<!--close-Header-part--> 

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-signal"></i> Charts &amp; graphs</a>
  <ul>
    <li><a href="TemperatureAndHumidity.html"><i class="icon icon-signal"></i> <span style="font-size:18px">Temp & Hum</span></a> </li>
	<li><a href="CO2AndLight.html"><i class="icon icon-inbox"></i> <span style="font-size:18px">CO2 & Light</span></a> </li>
	<li class="active"><a href="ElecrticityAndLight.html"><i class="icon icon-tint"></i> <span style="font-size:18px">Elecrticity & Water</span></a> </li>
    <li><a href="zigbee.html"><i class="icon icon-th"></i> <span style="font-size:18px">Zigbee Topology</span></a></li>
  </ul>
</div>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"><a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Environment Info</a></div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
		<div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5 style="color:green;font-size:18px">Temperature</h5>
          </div>
          <div class="widget-content">
		  <div id="temperatureholder"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5 style="color:blue;font-size:18px">Humidity</h5>
          </div>
          <div class="widget-content">
            <div id="humidityholder"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="/HTTP-Zigbee/app/Public/protected/js/jquery.min.js"></script> 
<script src="/HTTP-Zigbee/app/Public/protected/js/bootstrap.min.js"></script> 
<script src="/HTTP-Zigbee/app/Public/js/monitor.js"></script> 
<script src="/HTTP-Zigbee/app/Public/protected/js/highcharts.js"></script>
</body>
</html>