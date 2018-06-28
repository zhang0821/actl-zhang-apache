<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<title>Tables View</title>
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
	<li><a href="SleepAndCalories.html"><i class="icon icon-star"></i> <span style="font-size:18px">Sleep & Calories</span></a> </li>
    <li><a href="Zigbee.html"><i class="icon icon-signal"></i> <span style="font-size:18px">Zigbee & Location</span></a></li>
	<li class="active"><a href="Tables.html"><i class="icon icon-th"></i> <span style="font-size:18px">Tables View</span></a></li>
    <li><a href="History.html"><i class="icon icon-th"></i> <span style="font-size:18px">History Data</span></a></li>
  </ul>
</div>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Tables</a> </div>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5 style="color:green;font-size:20px">Environment Table</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
				  <th style="color:DarkCyan;font-size:20px">Room</th>
                  <th style="color:DarkCyan;font-size:20px;">Parameter</th>
                  <th style="color:DarkCyan;font-size:20px">Value</th>
				  <th style="color:DarkCyan;font-size:20px">Time</th>
                </tr>
              </thead>
              <tbody>
                <tr class="odd gradeX">
				  <td style="font-size:14px;font-weight:bold">9228</td>
                  <td style="font-size:14px;font-weight:bold">Temperature</td>
                  <td id="room_temperature" style="font-size:14px;font-weight:bold">23.1 ℃</td>
				  <td id="room_temperature_time" style="font-size:14px;font-weight:bold">2016-04-16 15:51:45</td>
                </tr>
                <tr class="even gradeC">
                  <td style="font-size:14px;font-weight:bold">9228</td>
				  <td style="font-size:14px;font-weight:bold">Humidity</td>
                  <td id="room_humidity" style="font-size:14px;font-weight:bold">40.1 RH%</td>  
				  <td id="room_humidity_time" style="font-size:14px;font-weight:bold">2016-04-16 15:51:45</td>
                </tr>
                <tr class="odd gradeA">
				  <td style="font-size:14px;font-weight:bold">9228</td>
                  <td style="font-size:14px;font-weight:bold">CO2</td>
                  <td id="room_co2" style="font-size:14px;font-weight:bold">800 PPM</td>
				  <td id="room_co2_time" style="font-size:14px;font-weight:bold">2016-04-16 15:51:45</td>
                </tr>
                <tr class="even gradeA">
				  <td style="font-size:14px;font-weight:bold">9228</td>
                  <td style="font-size:14px;font-weight:bold">Light</td>
                  <td id="room_light" style="font-size:14px;font-weight:bold">185 LUX</td>
				  <td id="room_light_time" style="font-size:14px;font-weight:bold">2016-04-16 15:51:45</td>
                </tr>
				<tr class="even gradeA">
				  <td style="font-size:14px;font-weight:bold">9228</td>
                  <td style="font-size:14px;font-weight:bold">Electricity</td>
                  <td id="room_electricity" style="font-size:14px;font-weight:bold">0.0024 KWH</td>
				  <td id="room_electricity_time" style="font-size:14px;font-weight:bold">2016-04-16 15:51:45</td>
                </tr>
				<tr class="even gradeA">
				  <td style="font-size:14px;font-weight:bold">9228</td>
                  <td style="font-size:14px;font-weight:bold">Water</td>
                  <td style="font-size:14px;font-weight:bold">0.36 m³</td>
				  <td style="font-size:14px;font-weight:bold">2016-04-16 15:51:45</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
	  <div class="row-fluid">
		  <div class="span12">
			<div class="widget-box">
			  <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
				<h5 style="color:PaleVioletRed;font-size:20px">Human Table</h5>
			  </div>
			  <div class="widget-content nopadding">
			    <table class="table table-bordered table-striped">
                  <thead>
					<tr>
					  <th style="color:Teal;font-size:20px">Username</th>
					  <th style="color:Teal;font-size:20px">Parameter</th>
					  <th style="color:Teal;font-size:20px">Value</th>
					  <th style="color:Teal;font-size:20px">Time</th>
					</tr>
				  </thead>
				  <tbody>
					<tr class="odd gradeX">
					  <td style="font-size:14px;font-weight:bold">Juno</td>
					  <td style="font-size:14px;font-weight:bold">SkinTemperature</td>
					  <td id="SkinTemperature" style="font-size:14px;font-weight:bold">31.0 ℃</td>
					  <td id="SkinTemperature_time" style="font-size:14px;font-weight:bold">2016-04-16 15:51:45</td>
					</tr>
					<tr class="even gradeC">
					  <td style="font-size:14px;font-weight:bold">Juno</td>
					  <td style="font-size:14px;font-weight:bold">HeartRate</td>
					  <td id="HeartRate" style="font-size:14px;font-weight:bold">76</td>
					  <td id="HeartRate_time" style="font-size:14px;font-weight:bold">2016-04-16 15:51:45</td>
					</tr>
					<tr class="odd gradeA">
					  <td style="font-size:14px;font-weight:bold">Juno</td>
					  <td style="font-size:14px;font-weight:bold">SleepTime</td>
					  <td id="SleepTime" style="font-size:14px;font-weight:bold">8h</td>
					  <td id="SleepTime_time" style="font-size:14px;font-weight:bold">2016-04-16 15:51:45</td>
					</tr>
					<tr class="even gradeA">
					  <td style="font-size:14px;font-weight:bold">Juno</td>
					  <td style="font-size:14px;font-weight:bold">Distance</td>
					  <td id="Distance" style="font-size:14px;font-weight:bold">38 m</td>
					  <td id="Distance_time" style="font-size:14px;font-weight:bold">2016-04-16 15:51:45</td>
					</tr>
					<tr class="even gradeA">
					  <td style="font-size:14px;font-weight:bold">Juno</td>
					  <td style="font-size:14px;font-weight:bold">Calories</td>
					  <td id="Calories" style="font-size:14px;font-weight:bold">10</td>
					  <td id="Calories_time" style="font-size:14px;font-weight:bold">2016-04-16 15:51:45</td>
					</tr>
				  </tbody>
				</table>
			  </div>
			</div>
		  </div>
    </div>
  </div>
</div>

<script src="/HTTP-Zigbee/app/Public/protected/js/jquery.min.js"></script> 
<script src="/HTTP-Zigbee/app/Public/protected/js/bootstrap.min.js"></script>
<script src="/HTTP-Zigbee/app/Public/js/Tables.js"></script>
</body>
</html>