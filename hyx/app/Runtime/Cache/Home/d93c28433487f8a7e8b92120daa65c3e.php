<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<title>SleepTime And Calories</title>
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

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome User</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
        <li class="divider"></li>
        <li><a href="login.html"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>
    <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i> <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
        <li class="divider"></li>
        <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
        <li class="divider"></li>
        <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
        <li class="divider"></li>
        <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="#"><i class="icon icon-cog"></i> <span class="text">Settings</span></a></li>
    <li class=""><a title="" href="login.html"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>



<!--sidebar-menu-->

<div id="sidebar">
  <ul>
    <li><a href="TemperatureAndHumidity.html"><i class="icon icon-asterisk"></i> <span style="font-size:18px">Temp & Hum</span></a> </li>
	<li><a href="CO2AndLight.html"><i class="icon icon-fire"></i> <span style="font-size:18px">CO2 & Light</span></a> </li>
	<li><a href="ElectricityAndWater.html"><i class="icon icon-bolt"></i> <span style="font-size:18px">Elecrticity & Water</span></a> </li>
	<li><a href="SkinAndHeart.html"><i class="icon icon-heart"></i> <span style="font-size:18px">SkinTemp & Heart</span></a> </li>
	<li class="active"><a href="SleepAndCalories.html"><i class="icon icon-star"></i> <span style="font-size:18px">Sleep & Calories</span></a> </li>
    <li><a href="Zigbee.html"><i class="icon icon-signal"></i> <span style="font-size:18px">Zigbee & Location</span></a></li>
	<li><a href="Tables.html"><i class="icon icon-th"></i> <span style="font-size:18px">Tables View</span></a></li>
    <li><a href="History.html"><i class="icon icon-th"></i> <span style="font-size:18px">History Data</span></a></li>
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
            <h5 style="color:green;font-size:18px">Sleep Time</h5>
          </div>
          <div class="widget-content">
		  <div id="sleeptimeholder"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
            <h5 style="color:blue;font-size:18px">Calories</h5>
          </div>
          <div class="widget-content">
            <div id="caloriesholder"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="/HTTP-Zigbee/app/Public/protected/js/jquery.min.js"></script> 
<script src="/HTTP-Zigbee/app/Public/protected/js/bootstrap.min.js"></script> 
<script src="/HTTP-Zigbee/app/Public/js/SleepAndCalories.js"></script> 
<script src="/HTTP-Zigbee/app/Public/protected/js/highcharts.js"></script>
</body>
</html>