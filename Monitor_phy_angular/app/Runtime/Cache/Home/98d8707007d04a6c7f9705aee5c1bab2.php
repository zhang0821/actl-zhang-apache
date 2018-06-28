<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ACTL华中师范大学图书馆温湿度管理系统</title>
<script type="text/javascript" src="/HTTP-Zigbee/app/Public/Monitor/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/HTTP-Zigbee/app/Public/Monitor/js/jquery.min.js"></script>   
<script src="/HTTP-Zigbee/app/Public/Monitor/js/bootstrap.min.js"></script>  
<meta name="viewport" content="width:1080px, initial-scale=1.0, maximum-scale=1.0"/>
<link rel="stylesheet" href="/HTTP-Zigbee/app/Public/Monitor/css/bootstrap.min.css">
<link rel="stylesheet" href="/HTTP-Zigbee/app/Public/Monitor/css/TempAndHumidity.css" type="text/css" />
<script type="text/javascript" src="/HTTP-Zigbee/app/Public/Monitor/js/TempAndHumidity.js"></script>
<script type="text/javascript" src="/HTTP-Zigbee/app/Public/Monitor/js/highcharts.js"></script>
</head>
<body align="center" id="WholeBody" >
<noscript>

　　<iframe scr="*.htm"></iframe>

</noscript>
<!--页面正文之前-->
	<div id="PageTop" style="width:1080px;height:auto;float: left;border-bottom:2px solid #399;">
		<div id="FilterBox" style="width: 1080px;height: auto;float: left;"></div>
		<div class="header" id="FixHeader" style="width: 100%;height:80px;background-color:#399;float:left;">
		<!--导航栏左-->
          	<div class="TimeBox" style="width:400px;height:80px;float:left;">
          		<img class="clk_pct" src="/HTTP-Zigbee/app/Public/Monitor/img/CCNU-logo2.png"/>
					<h5 id="top_title_text" >
						<script >
							document.write(year + '年' + mon + '月' + day + '日   ' + week);
						</script>
					</h5>
          	</div>
        <!--导航栏右-->
          	<div class="SettingBox" id="SettingButton" style="float:right;width:480px;height:800px;">	    
				<ul style="width: 100%;height:30px;margin-top:20px;">
					<li class="li_ho" onclick="UpdateTemAndHumThreshold(8)" ><a data-toggle="modal" data-target="#myModal1" class="li_text">阈值配置</a>
                    </li>
            		<li class="li_ho">
                        <a data-toggle="modal" data-target="#myModal3" class="li_text">新增用户</a>
                    </li>

                    <li class="li_ho">
                        <a data-toggle="modal" data-target="#myModal4" class="li_text">信息修改</a>
                    </li>

                    <li class="li_ho">
                        <a data-toggle="modal"  class="li_text">新增节点</a>
                    </li>
                    <!--
                    <li class="li_ho">
                        <a data-toggle="dropdown"  href="#" class="li_text" >新增节点
                        </a>
                        <ul id="add-menu" class="dropdown-menu" style="width:60px;background-color:rgba(255,255,255,0.75);position:absolute;top:50px;left:950px;">
                                    <script>
                                        var html="";
                                        for(var i=1;i<10;i++)
                                        {
                                            html+='<li><a data-toggle="modal" data-target="#myModaladdf'+i+'" style=" font-weight:800; font-size:14px;color:#267EAA;">'+i+'楼新增</a></li>';
                                        }
                                        document.getElementById("add-menu").innerHTML+=html;
                                        html="";
                                    </script>                    
                        </ul>
                    </li>
                    -->   
            	</ul>   
        	</div>
		</div>

<!--标题显示切换内容-->
		<div id="TitleBtn" style="position:absolute;width:1080px;height:80px;left:0;top:0;background-color:#399;z-index: 10;">
			<img  src="/HTTP-Zigbee/app/Public/Monitor/img/CCNU-logo2.png" style="width: 50px;height: 50px;float: left;margin-left:10px;margin-top: 15px;" />
			<div style="width:200px;height:80px;float:left;">
					<h5 style="font-size:15px;color:#fff;margin-left:5px;text-decoration:none;float:left;margin-top:33px;font-family:微软雅黑;font-size: bold;" >
						<script >
							document.write(year + '年' + mon + '月' + day + '日   ' + week);
						</script>
					</h5>
			</div>
		    <div id="Libpct" style="width:540px;margin-left:20px;height:80px;float: left;color:#fff;font-size:32px;text-align: center; line-height:80px;font-family:微软雅黑;">
		    华中师范大学图书馆温湿度检测系统
		    </div>
		</div><!--切换结束-->

		<div style="float: left;width:1080px;height:350px;background-color:#ccc;">
			<img style="width:100%;height:350px;float:left;" src="/HTTP-Zigbee/app/Public/Monitor/img/图书馆.jpg"/>
		</div>
	</div>

<!--页面中间主要部分-->
	<div id="PageMain" align="center"  style="width:1080px;height:auto;background-color:#F4EDE7;">
	<!--节点标识说明-->
	   <!--用于坐标定位时的小栗子
<button onclick="f1zb_add()"> 11</button>
<div id="text11" style="width:300px;height:30px;position: absolute;top: 500px;left: 30px;z-index: 100;"></div>--><!---->
		<div class="IdentDesc" style="width:400px;height:30px;background-color:#F4EDE7;float:right;margin-right:50px;margin-top:20px;">        
			<div class="imgstyle" ><img src="/HTTP-Zigbee/app/Public/Monitor/img/red.PNG" style="width:26px;height:26px;" /> 温湿度异常</div>
			<div class="imgstyle" ><img src="/HTTP-Zigbee/app/Public/Monitor/img/green.PNG" style="width:25px;height:25px;" />温湿度正常</div>
			<div class="imgstyle" ><img src="/HTTP-Zigbee/app/Public/Monitor/img/grey.PNG" style="width:25px;height:25px;" />节点已离线</div> 
		</div>
	<!--页面主要内容显示-->
		<div id="Mainbody" style="width:1000px;height:auto;margin-left:auto;margin-right:auto;">
		<!--楼层选项卡-->
		  	<nav id="FixFr" class="navbar-fixed-bottom" style="position:absolute;position:fixed;background-color:#399;width:1080px;height:60px;left:0;z-index: 10">
				<ul id="main-libfloor" class="nav nav-tabs li_fr" style="width:100%;font-size:17px;margin-top:15px;font-weight:600;font-family:微软雅黑;background-color:#399;" >
					<li role="presentation"  onclick="floorshow(1)" ><a href="#1f" aria-controls="1f" role="tab" data-toggle="tab" style="color: #9cf; ">图书馆一楼</a></li>
					<li role="presentation"  onclick="floorshow(2)" ><a href="#2f" aria-controls="2f" role="tab" data-toggle="tab" style="color: #9cf; ">图书馆二楼</a></li> 
					<li role="presentation"  onclick="floorshow(3)" ><a href="#3f" aria-controls="3f" role="tab" data-toggle="tab" style="color: #9cf; ">图书馆三楼</a></li>
					<li role="presentation"  onclick="floorshow(4)" ><a href="#4f" aria-controls="4f" role="tab" data-toggle="tab" style="color: #9cf; ">图书馆四楼</a></li>
					<li role="presentation"  onclick="floorshow(5)" ><a href="#5f" aria-controls="5f" role="tab" data-toggle="tab" style="color: #9cf; ">图书馆五楼</a></li>
					<li role="presentation"  onclick="floorshow(6)" ><a href="#6f" aria-controls="6f" role="tab" data-toggle="tab" style="color: #9cf; ">图书馆六楼</a></li>
					<li role="presentation"  onclick="floorshow(7)" ><a href="#7f" aria-controls="7f" role="tab" data-toggle="tab" style="color: #9cf; ">图书馆七楼</a></li>
					<li role="presentation" class="active" onclick="floorshow(8)" ><a href="#8f" aria-controls="8f" role="tab" data-toggle="tab" style="color: #9cf; ">图书馆八楼</a></li>
					<li role="presentation"  onclick="floorshow(9)" ><a href="#9f" aria-controls="9f" role="tab" data-toggle="tab" style="color: #9cf; ">图书馆九楼</a></li> 
				</ul>
			</nav>
		<!--容器:画点画图-->
			<div class="container" style="width:900px;" >
				<div class="row">
					<div class="span6">					
						<div  class="tab-content" style="width:100%;height:auto; margin-top:5px;">
						<!--图书馆一楼布局页面-->
							<div role="tabpanel"  class="tab-pane " id="1f">
								<div class="f1_box" >
									<div id="f1_box_pct" style="position:relative;" >
										<div id="sensorBox1" >
										</div>
									</div>   
									<div class="f1_diagram" >
										<!--节点轮播--> 
										<div id="f1_carousel" class="carousel slide" data-ride="carousel" style="width:100%;height:100%;">
											<ol  class="carousel-indicators">
												<li data-target="#f1_Carousel" data-slide-to="0" class="active"></li>
												<li data-target="#f1_Carousel" data-slide-to="1" ></li>
											</ol>
											<div id="lunbopage1" class="carousel-inner" role="listbox"></div>										
											<a class="left carousel-control" href="#f1_carousel" role="button" data-slide="prev">										
											<span class="sr-only">Previous</span></a>
											<a class="right carousel-control" href="#f1_carousel" role="button" data-slide="next">										
											<span class="sr-only">Next</span></a>
										</div>
										<!--轮播结束--> 
									</div>                            
								</div>
							</div>

						<!--图书馆2楼布局页面-->
							<div role="tabpanel"  class="tab-pane " id="2f">
								<div class="f2_box" >
									<div id="f2_box_pct" style="position:relative;" >
										<div id="sensorBox2" >
										</div>
									</div>   
									<div class="f2_diagram" >
										<!--节点轮播--> 
										<div id="f2_carousel" class="carousel slide" data-ride="carousel" style="width:100%;height:100%;">
											<ol  class="carousel-indicators">
												<li data-target="#f2_Carousel" data-slide-to="0" class="active"></li>
												<li data-target="#f2_Carousel" data-slide-to="1" ></li>
											</ol>
											<div id="lunbopage2" class="carousel-inner" role="listbox"></div>										
											<a class="left carousel-control" href="#f2_carousel" role="button" data-slide="prev">										
											<span class="sr-only">Previous</span></a>
											<a class="right carousel-control" href="#f2_carousel" role="button" data-slide="next">										
											<span class="sr-only">Next</span></a>
										</div>
										<!--轮播结束--> 
									</div>                            
								</div>
							</div>

						<!--图书馆3楼布局页面-->
							<div role="tabpanel"  class="tab-pane " id="3f">
								<div class="f3_box" >
									<div id="f3_box_pct" style="position:relative;" >
										<div id="sensorBox3" >
										</div>
									</div>   
									<div class="f3_diagram" >
										<!--节点轮播--> 
										<div id="f3_carousel" class="carousel slide" data-ride="carousel" style="width:100%;height:100%;">
											<ol  class="carousel-indicators">
												<li data-target="#f3_Carousel" data-slide-to="0" class="active"></li>
												<li data-target="#f3_Carousel" data-slide-to="1" ></li>
											</ol>
											<div id="lunbopage3" class="carousel-inner" role="listbox"></div>										
											<a class="left carousel-control" href="#f3_carousel" role="button" data-slide="prev">										
											<span class="sr-only">Previous</span></a>
											<a class="right carousel-control" href="#f3_carousel" role="button" data-slide="next">										
											<span class="sr-only">Next</span></a>
										</div>
										<!--轮播结束--> 
									</div>                            
								</div>
							</div>

						<!--图书馆4楼布局页面-->
							<div role="tabpane1"  class="tab-pane " id="4f">
								<div class="f4_box" >
									<div id="f4_box_pct" style="position:relative;" >
										<div id="sensorBox4" >
										</div>
									</div>   
									<div class="f4_diagram" >
										<!--节点轮播--> 
										<div id="f4_carousel" class="carousel slide" data-ride="carousel" style="width:100%;height:100%;">
											<ol  class="carousel-indicators">
												<li data-target="#f4_Carousel" data-slide-to="0" class="active"></li>
												<li data-target="#f4_Carousel" data-slide-to="1" ></li>
											</ol>
											<div id="lunbopage4" class="carousel-inner" role="listbox"></div>										
											<a class="left carousel-control" href="#f4_carousel" role="button" data-slide="prev">										
											<span class="sr-only">Previous</span></a>
											<a class="right carousel-control" href="#f4_carousel" role="button" data-slide="next">										
											<span class="sr-only">Next</span></a>
										</div>
										<!--轮播结束--> 
									</div>                            
								</div>
							</div>

						<!--图书馆5楼布局页面-->
							<div role="tabpanel"  class="tab-pane " id="5f">
								<div class="f5_box" >
									<div id="f5_box_pct" style="position:relative;" >
										<div id="sensorBox5" >
										</div>
									</div>   
									<div class="f5_diagram" >
										<!--节点轮播--> 
										<div id="f5_carousel" class="carousel slide" data-ride="carousel" style="width:100%;height:100%;">
											<ol  class="carousel-indicators">
												<li data-target="#f5_Carousel" data-slide-to="0" class="active"></li>
												<li data-target="#f5_Carousel" data-slide-to="1" ></li>
											</ol>
											<div id="lunbopage5" class="carousel-inner" role="listbox"></div>										
											<a class="left carousel-control" href="#f5_carousel" role="button" data-slide="prev">										
											<span class="sr-only">Previous</span></a>
											<a class="right carousel-control" href="#f5_carousel" role="button" data-slide="next">										
											<span class="sr-only">Next</span></a>
										</div>
										<!--轮播结束--> 
									</div>                            
								</div>
							</div>

						<!--图书馆6楼布局页面-->
							<div role="tabpanel"  class="tab-pane " id="6f">
								<div class="f6_box" >
									<div id="f6_box_pct" style="position:relative;" >
										<div id="sensorBox6" >
										</div>
									</div>   
									<div class="f6_diagram" >
										<!--节点轮播--> 
										<div id="f6_carousel" class="carousel slide" data-ride="carousel" style="width:100%;height:100%;">
											<ol  class="carousel-indicators">
												<li data-target="#f6_Carousel" data-slide-to="0" class="active"></li>
												<li data-target="#f6_Carousel" data-slide-to="1" ></li>
											</ol>
											<div id="lunbopage6" class="carousel-inner" role="listbox"></div>										
											<a class="left carousel-control" href="#f6_carousel" role="button" data-slide="prev">										
											<span class="sr-only">Previous</span></a>
											<a class="right carousel-control" href="#f6_carousel" role="button" data-slide="next">										
											<span class="sr-only">Next</span></a>
										</div>
										<!--轮播结束--> 
									</div>                            
								</div>
							</div>

						<!--图书馆7楼布局页面-->
							<div role="tabpanel"  class="tab-pane " id="7f">
								<div class="f7_box" >
									<div id="f7_box_pct" style="position:relative;" >
										<div id="sensorBox7" >
										</div>
									</div>   
									<div class="f7_diagram" >
										<!--节点轮播--> 
										<div id="f7_carousel" class="carousel slide" data-ride="carousel" style="width:100%;height:100%;">
											<ol  class="carousel-indicators">
												<li data-target="#f7_Carousel" data-slide-to="0" class="active"></li>
												<li data-target="#f7_Carousel" data-slide-to="1" ></li>
											</ol>
											<div id="lunbopage7" class="carousel-inner" role="listbox"></div>										
											<a class="left carousel-control" href="#f7_carousel" role="button" data-slide="prev">										
											<span class="sr-only">Previous</span></a>
											<a class="right carousel-control" href="#f7_carousel" role="button" data-slide="next">										
											<span class="sr-only">Next</span></a>
										</div>
										<!--轮播结束--> 
									</div>                            
								</div>
							</div>
						<!--图书馆8楼布局页面-->
							<div role="tabpanel" class="tab-pane active " id="8f">
								<div class="f8_box"  >                    
									<div id="f8_box_pct" style="position:relative;" >
										<div id="sensorBox8" >
										</div><!-- --> 											
									</div> 
									<div class="f8_diagram">
										<!--节点轮播--> 
										<div id="f8_carousel" class="carousel slide" data-ride="carousel" style="width:100%;height:100%;">
											<ol  class="carousel-indicators">
												<li data-target="#f8_Carousel" data-slide-to="0" class="active"></li>
												<li data-target="#f8_Carousel" data-slide-to="1" ></li>
												<li data-target="#f8_Carousel" data-slide-to="2" ></li>
												<li data-target="#f8_Carousel" data-slide-to="3" ></li>
											</ol>
											<div id="lunbopage8" class="carousel-inner" role="listbox">	</div>									  		
											<a class="left carousel-control" href="#f8_carousel" role="button" data-slide="prev">
											<span class="sr-only">Previous</span></a>
											<a class="right carousel-control" href="#f8_carousel" role="button" data-slide="next">
											<span class="sr-only">Next</span></a>
										</div>
										<!--轮播结束-->                                                                  
									</div> 
								</div>
							</div> 

						<!--图书馆9楼布局页面-->
							<div role="tabpanel"  class="tab-pane " id="9f">
								<div class="f9_box" >
									<div id="f9_box_pct" style="position:relative;" >
										<div id="sensorBox9" >
										</div>
									</div>   
									<div class="f9_diagram" >
										<!--节点轮播--> 
										<div id="f9_carousel" class="carousel slide" data-ride="carousel" style="width:100%;height:100%;">
											<ol  class="carousel-indicators">
												<li data-target="#f9_Carousel" data-slide-to="0" class="active"></li>
												<li data-target="#f9_Carousel" data-slide-to="1" ></li>
											</ol>
											<div id="lunbopage9" class="carousel-inner" role="listbox"></div>										
											<a class="left carousel-control" href="#f9_carousel" role="button" data-slide="prev">										
											<span class="sr-only">Previous</span></a>
											<a class="right carousel-control" href="#f9_carousel" role="button" data-slide="next">										
											<span class="sr-only">Next</span></a>
										</div>
										<!--轮播结束--> 
									</div>                            
								</div>
							</div>                
						</div> 
			  		</div>
				</div>
		  	</div><!--container结束-->

		</div><!--Mainbody结束-->
	</div>

<!--页面底部版权内容-->
<div style="width: 1080px;height:110px;background-color:#F4EDE7;float:left;">
	<div class="PageBottom" style="width: 1080px;height:80px;background-color:#F4EDE7;float:left;margin-top:10px;">
		<p>
			<P align="center"><FONT color="#399" style="line-height: 15px;font-family:微软雅黑;font-size: 8px">华中师范大学图书馆，版权所有 2012-2016，Copyright (C) 2012 CCNULIB All Right Reserved<BR style="font-family: "></FONT></P>
			<P align="center"><FONT color="#399" style="line-height: 15px;font-family:微软雅黑;font-size: 8px">湖北省武汉市珞瑜路152号， 邮政编码：430079 电话：（086）27-67868359 传真：（086）27-67868359</FONT></P>
			<P align="center"><FONT color="#399" style="line-height: 15px;font-family:微软雅黑;font-size: 8px">Created By ACTL 现代通信技术实验室</FONT></P>
		</p>
	</div>
</div>
<!--阈值配置弹窗-->
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"  style="position: absolute;top: 27%;left:40px;">
		<div class="modal-dialog" role="document" style="width:1000px;">
		    <div class="modal-content">
		        <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel" style="font-size:30px;color:#0aa;text-align:center;">温湿度报警阈值配置</h4>
		        </div>
		        <div class="modal-body" >
		        	<!----内容开始---->
			        <div class="xxk" >
			            <!-- Nav tabs -->
			            <ul class="nav nav-pills nav-stacked" role="tablist" style="font-size:20px;background-color:#bbb;width:150px;height:auto;float:left;">
			                <li role="presentation" onclick="UpdateTemAndHumThreshold(1)"><a href="#1fr" aria-controls="1fr" role="tab" data-toggle="tab">图书馆一楼</a></li>
			                <li role="presentation" onclick="UpdateTemAndHumThreshold(2)"><a href="#2fr" aria-controls="2fr" role="tab" data-toggle="tab">图书馆二楼</a></li>
			                <li role="presentation" onclick="UpdateTemAndHumThreshold(3)"><a href="#3fr" aria-controls="3fr" role="tab" data-toggle="tab">图书馆三楼</a></li>
			                <li role="presentation" onclick="UpdateTemAndHumThreshold(4)"><a href="#4fr" aria-controls="4fr" role="tab" data-toggle="tab">图书馆四楼</a></li>
			                <li role="presentation" onclick="UpdateTemAndHumThreshold(5)"><a href="#5fr" aria-controls="5fr" role="tab" data-toggle="tab">图书馆五楼</a></li>
			                <li role="presentation" onclick="UpdateTemAndHumThreshold(6)"><a href="#6fr" aria-controls="6fr" role="tab" data-toggle="tab">图书馆六楼</a></li>
			                <li role="presentation" onclick="UpdateTemAndHumThreshold(7)"><a href="#7fr" aria-controls="7fr" role="tab" data-toggle="tab">图书馆七楼</a></li>
			                <li role="presentation" class="active" onclick="UpdateTemAndHumThreshold(8)"><a href="#8fr" aria-controls="8fr" role="tab" data-toggle="tab" >图书馆八楼</a></li>
			                <li role="presentation" onclick="UpdateTemAndHumThreshold(9)"><a href="#9fr" aria-controls="9fr" role="tab" data-toggle="tab">图书馆九楼</a></li>
			            </ul>
			            <!-- Tab panes -->
			            <div id="1-7fr" class="tab-content">
			                <div role="tabpanel" class="tab-pane" id="1fr">
			                    <div class="tc_box_right" >
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室一</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle" id="templowF1R1"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF1R1"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF1R1"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF1R1"/>
			                            </div>
			                        </div>
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室二</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF1R2"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF1R2"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF1R2"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF1R2"/>
			                            </div>
			                        </div>
			                    </div> 
			                </div>
			                <div role="tabpanel" class="tab-pane" id="2fr">
			                    <div class="tc_box_right" >
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室一</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF2R1"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF2R1"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF2R1"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF2R1"/>
			                            </div>
			                        </div>
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室二</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF2R2"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF2R2"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF2R2"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF2R2"/>
			                            </div>
			                        </div>
			                    </div>            
			                </div>
			                <div role="tabpanel" class="tab-pane" id="3fr">
			                    <div class="tc_box_right" >
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室一</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF3R1"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF3R1"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF3R1"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF3R1"/>
			                            </div>
			                        </div>
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室二</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF3R2"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF3R2"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF3R2"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF3R2"/>
			                            </div>
			                        </div>
			                    </div>            
			                </div>
			                <div role="tabpanel" class="tab-pane" id="4fr">
			                    <div class="tc_box_right" >
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室一</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF4R1"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF4R1"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF4R1"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF4R1"/>
			                            </div>
			                        </div>
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室二</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF4R2"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF4R2"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF4R2"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF4R2"/>
			                            </div>
			                        </div>
			                    </div>            
			                </div>
			                <div role="tabpanel" class="tab-pane" id="5fr">
			                    <div class="tc_box_right" >
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室一</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF5R1"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF5R1"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF5R1"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF5R1"/>
			                            </div>
			                        </div>
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室二</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF5R2"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF5R2"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF5R2"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF5R2"/>
			                            </div>
			                        </div>
			                    </div>            
			                </div>
			                <div role="tabpanel" class="tab-pane" id="6fr">
			                    <div class="tc_box_right" >
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室一</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF6R1"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF6R1"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF6R1"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF6R1"/>
			                            </div>
			                        </div>
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室二</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF6R2"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF6R2"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF6R2"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF6R2"/>
			                            </div>
			                        </div>
			                    </div>            
			                </div>
			                <div role="tabpanel" class="tab-pane" id="7fr">
			                    <div class="tc_box_right" >
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室一</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF7R1"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF7R1"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF7R1"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF7R1"/>
			                            </div>
			                        </div>
			                        <div class="tc_box" >
			                            <h4 >中文图书阅览室二</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF7R2"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF7R2"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF7R2"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF7R2"/>
			                            </div>
			                        </div>
			                    </div>            
			                </div>
			                <div role="tabpanel" class="tab-pane active" id="8fr">
			                    <div class="tc_box_right" > 
			                    	<div class="tc_box8" >
				                    	<h4 >特藏阅览室一</h4>
				                    	<div style="width:50%;height:150px;float:left;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF8R1" />
			                            <h5 style="color:#000;margin-top:10px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF8R1"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF8R1"/>
			                            <h5 style="color:#000;margin-top:10px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF8R1"/>
			                            </div>
			                        </div>
			                    	<div class="tc_box8" >
				                    	<h4 >特藏阅览室二</h4>
				                    	<div style="width:50%;height:150px;float:left;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF8R2"/>
			                            <h5 style="color:#000;margin-top:10px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF8R2"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF8R2"/>
			                            <h5 style="color:#000;margin-top:10px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF8R2"/>
			                            </div>
			                        </div>
			                    	<div class="tc_box8" >
				                    	<h4 >古籍阅览室一</h4>
				                    	<div style="width:50%;height:150px;float:left;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF8R3"/>
			                            <h5 style="color:#000;margin-top:10px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF8R3"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF8R3"/>
			                            <h5 style="color:#000;margin-top:10px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF8R3"/>
			                            </div>
			                    	</div>
			                    	<div class="tc_box8" >
				                    	<h4 >古籍阅览室二</h4>
				                    	<div style="width:50%;height:150px;float:left;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF8R4"/>
			                            <h5 style="color:#000;margin-top:10px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF8R4"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF8R4"/>
			                            <h5 style="color:#000;margin-top:10px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF8R4"/>
			                            </div>  
			                    	</div>
			                    </div>
			                </div>
			                <div role="tabpanel" class="tab-pane" id="9fr">
			                    <div class="tc_box_right" >
			                        <div class="tc_box" >
			                            <h4 >Room 1</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF9R1"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF9R1"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF9R1"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF9R1"/>
			                            </div>
			                        </div>
			                        <div class="tc_box" >
			                            <h4 >Room 2</h4>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">温度最低门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="templowF9R2"/>
			                            <h5 style="color:#000;margin-top:30px;">温度最高门限</h5>
			                            <input type="number" min="-20" max="100" class="THstyle"  id="temphighF9R2"/>
			                            </div>
			                            <div style="width:50%;height:150px;float:left;margin-top:20px;">
			                            <h5 style="color:#000;">湿度最低门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humilowF9R2"/>
			                            <h5 style="color:#000;margin-top:30px;">湿度最高门限</h5>
			                            <input type="number" min="0" max="100" class="THstyle"  id="humihighF9R2"/>
			                            </div>
			                        </div>
			                    </div>                                                          
			                </div>
			            </div>
			        </div>
		    	</div>
					<!----内容结束---->
			    <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal" onclick=" DeleteTCText()" >Close</button>
			        <button type="button" class="btn btn-primary" onclick="PostTemHumThreConf()" >Save changes</button>
			    </div>
		    </div>
		</div>
	</div>
<!----新增用户---->
		<div class="modal fade" id="myModal3" tabindex5r4="-1" role="dialog" aria-labelledby="myModalLabel" style="position: absolute;top: 27%;left: 80px;">
		  	<div class="modal-dialog" role="document" style="width:800px;">
			    <div class="modal-content">
				     <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel" style="font-size:2.5em;color:#0aa;text-align:center;">添加新用户</h4>
				     </div>
					<div class="modal-body" align="center" >
					<!----内容开始---->
						  <div class="SNU_mainbody" style="width:600px; height:auto;">
						    <form enctype="multipart/form-data" action="" method="post" name="AddNU">
						        <div class="SY">
						          <label for ="newuser"><h4>添加新登录账号：</h4></label><br />
						          <input type="text" name="newuser" id="newuser" class="newinfo" value=""/>
						        </div>
						        <div class="SY">
						          <label for ="newpass"><h4>设置登录密码：</h4></label><br />
						          <input type="password" name="newpass" id="newpass" class="newinfo" value=""/>
						        </div>
						        <div class="SY">
						          <label for ="telephone"><h4>用户手机号码：</h4></label><br />
						          <input type="number" name="telephone" id="telephone" class="newinfo" value="" />
						        </div>
								<div class="SY">
						          <label for ="mailbox"><h4>用户邮箱：</h4></label><br />
						          <input type="text" name="mailbox" id="mailbox" class="newinfo" value="" />
						        </div>
						        <div class="SY">
						            <label for ="setlevel"><h4>设定权限：</h4></label><br />
						            <select name="setlevel" id="setlevel" class="newinfo">
										<OPTION value="0" class="set" >普通用户</OPTION>
						                <OPTION value="1" class="set">管理员</OPTION>                
						            </select>
						        </div>
						    </form>
						  </div>
					</div>
			<!----内容结束---->
			        <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="ReSetNU()">Close</button>
				        <button type="button" class="btn btn-primary" onclick="AddNewUser()" >Save changes</button>
			        </div>
			    </div>
		  	</div>
		</div>
<!----修改信息弹窗---->
		<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="position: absolute;top: 27%;left: 80px;">
		  	<div class="modal-dialog" role="document" style="width:800px;">
		    	<div class="modal-content">
			        <div class="modal-header">
				        <div>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				            <h2 style="font-size:2.5em;color:#0aa;text-align:center;">密码重置</h2>
				        </div>
			        </div>
					<div class="modal-body" >
					<!--内容开始-->
							<div class="changeinfo_mainbody" style="width:80%; margin-left:10%;height:auto;text-align: 
							center;">
							    <form enctype="multipart/form-data" action="" method="post" name="ChangeIF">
							        <div class="xg">
							          <label for ="srysmm"><h4>输入原始登录密码：</h4></label><br />
							          <input type="password" name="srysmm" id="firstpwd" class="srysmm" value="" style="width:250px; height:30px;"/>
							        </div>
							        <div class="xg">
							          <label for ="setxmm"><h4>设定新密码：</h4></label><br />
							          <input type="password" name="setxmm" id="secondpwd" class="setxmm" value="" style="width:250px; height:30px;"/>
							        </div>
							        <div class="xg">
							          <label for ="snpagain"><h4>再次输入新密码：</h4></label><br />
							          <input type="password" name="snpagain" id="secondpwdagain" class="snpagain" value="" style="width:250px; height:30px;" />
							        </div>        
							    </form>
							</div>
					  <!----内容结束---->
					</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-default" data-dismiss="modal" onclick="ReSetNU()">Close</button>
			        	<button type="button" class="btn btn-primary" onclick="ModifyUserInfo()" >Save changes</button>
			      	</div>
		    	</div>
		  	</div>
		</div>
<!--新增节点弹窗-->
	<script> 
	for(var i=1;i<10;i++){
		document.getElementById("WholeBody").innerHTML+='<!--                                  添加新节点弹窗9楼                        --><div class="modal fade" id="myModaladdf'+i+'" tabindex5r4="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document" style="width:910px;position: absolute;top:27%;left: 80px;"><div class="modal-content"><div class="modal-header" style="width:100%;height:50px;"><button class="btn add" onclick="zb_add('+i+')">Add Sensor</button><button class="btn add" onclick="zb_delete('+i+')" >Delete</button></div><div class="modal-body" ><!--内容开始--><div id="f'+i+'_box_add" style="width:800px;height:500px;background-color:#fff;"><div id="text" style="width:100%;height:50px;"></div><div id="f'+i+'_box_addpct" style="position:relative;"></div></div><!----内容结束----><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal" onclick="CloseDelete('+i+')">Close</button><button type="button" class="btn btn-primary" onclick="SaveNewSensor('+i+')">Save changes</button></div></div></div></div> </div> <!--添加节点结束-->';
	}
	</script>
<!--警告框-->
	<div id="Warningboxhide" style="overflow:hidden;position:absolute;top:800px;left:5px;width:80px;height:620px;"> 
		<div align="center" id="warningbox" style="overflow:hidden;height:480px;width:50px;margin-left:auto;margin-right:auto;font-size:28px;font-family:微软雅黑;color:#399;line-height:28px;text-align:center;padding:10px">        
	    </div>
	</div>
<!--内容切换按键-->
	<div id="ShowHidebtn" >
		<button style="background-color:#EA700E;border-top: 1px solid #FFFFFF;border-left: 1px solid #FFFFFF;border-bottom: 1px solid #fff;border-right: 1px solid #fff;width:30px;height:30px;border-radius:50% 50%;margin-top:10px;">
		</button>
	</div>

	<div id="WarnConfirmBtn" onclick="warningconfirm()" >
		<button style="background-color:#EA700E;border-top: 1px solid #FFFFFF;border-left: 1px solid #FFFFFF;border-bottom: 1px solid #fff;border-right: 1px solid #fff;width:30px;height:30px;border-radius:50% 50%;margin-top:10px; ">
		</button>
	</div>
<!--显示当前节点温湿度值的盒子-->
<div id="InfoBox"></div>
</body>
</html>