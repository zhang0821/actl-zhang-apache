<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />  
<meta name="viewport" content="width:1400px, initial-scale=1.0, maximum-scale=1.0"/>
<title>节点信息查询-ACTL</title>
<link href="/HTTP-Zigbee/app/Public/Monitor/css/bootstrap.min.css" rel="stylesheet">
<link href="/HTTP-Zigbee/app/Public/Monitor/css/TempAndHumidity.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/HTTP-Zigbee/app/Public/Monitor/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/HTTP-Zigbee/app/Public/Monitor/js/jquery.min.js"></script> 
<script src="/HTTP-Zigbee/app/Public/Monitor/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/HTTP-Zigbee/app/Public/Monitor/js/TemHumTable.js"></script>
</head>

<body >
<img style="position:absolute;left:0px;top:0px;width:100%;height:1700px;z-index:-1;" src="/HTTP-Zigbee/app/Public/Monitor/img/table1.PNG" />
<div style="position:absolute;position:fixed;width:100%;height:10px;top:80px;background-color:#F4EDE7;"></div>
	<div  style="width:1400px;margin:0 auto;height:auto;" >
		<div class="CIheader" style="width:100%;min-width:1400px;height:30px">
	            <div class="container" >
	            	<div class="row" >
		                <nav class="navbar navbar-default navbar-fixed-top navbar-inverse"  style="background-color:#399; border:0px; height:80px;">
		                  <!-- <div class="header-logo"> -->
		                    <div class="navbar-header " style="height:80px;">
		                      <img class="clk_pct" src="/HTTP-Zigbee/app/Public/Monitor/img/CCNU-logo1.png"/>
		                      <h5 id="top_title_text" >
		                              <script >
		                              //时间显示
											var mydate=new Date;
											var weekday=["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];
											var day=mydate.getDate();
											var nday=mydate.getDay();
											var mon=mydate.getMonth()+1;
											var year=mydate.getFullYear();
											var week=weekday[nday];
		                                  document.write(year + '年' + mon + '月' + day + '日   ' + week);
		                              </script>
		                      </h5>
		                    </div>                  
		                  
		                    <div class="collapse navbar-collapse " id="navbar-collapse" style="float:right; margin-right:20px;">
		                        <ul class="nav navbar-nav">
		                          <li style="width:330px; height:50px; text-align:center;"><a  style=" font-size: 20px;color: #fff;line-height:50px;font-weight:bold;font-family:微软雅黑;">图书馆温湿度节点信息查询</a>
		                          </li>
		                          <li class="active"></li>
		                    </div>

		                  </nav>      
	                </div>
	             </div><!-- 控件结束-->

		</div>	<!--header结束-->

		<div class="CImainbody" style="width:100%;min-width:1200px;height:auto;">
			 <div class="container" style="width:100%;" >
		            <div class="row">
		                <div class="span6">
		                       
		            			<!--table panes-->
					            <div  class="tab-content" style="width:100%;height:auto; margin-top:20px;">

					            <!--图书馆一楼布局页面-->
				                    <div role="tabpanel"  class="tab-pane " id="CI1f">
								        <div class="f1_box" style="height:auto;"><!--style="background-color:#9cf;"-->

				                            <div id="f1_box_pct" style="position:relative;position:fixed;" >
				                            
				                            </div>
				   
				                            <div class="tablef1" style="width:100%;margin-top:530px;height:auto;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Temperature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">SensorStatus</th>
																<th class="tableTitle">DateTime</th>																
															</tr>
													  </thead>
													  <tbody id="f1current_data"></tbody>
												</table>				                              
				                            </div> 
				                            
				                        </div>

                    				</div>

				                    <div role="tabpanel"  class="tab-pane " id="CI2f">
				                        <div class="f2_box" style="height:auto;">
				                            <div id="f2_box_pct" style="position:relative;position:fixed;" >
				                            
				                            </div>

				                            <div class="tablef2" style="width:100%;margin-top:530px;height:auto;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Temperature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">SensorStatus</th>
																<th class="tableTitle">DateTime</th>
															</tr>
													  </thead>
													  <tbody id="f2current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>

				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI3f">
				                       <div class="f3_box" style="height:auto;">
				                            <div id="f3_box_pct" style="position:relative;position:fixed;" >
				                            
				                            </div>

				                            <div class="tablef3" style="width:100%;margin-top:530px;height:auto;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Temperature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">SensorStatus</th>
																<th class="tableTitle">DateTime</th>
															</tr>
													  </thead>
													  <tbody id="f3current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI4f">
				                        <div class="f4_box" style="height:auto;">
				                            <div id="f4_box_pct" style="position:relative;position:fixed;" >
				                            
				                            </div>

				                            <div class="tablef4" style="width:100%;margin-top:530px;height:auto;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Temperature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">SensorStatus</th>
																<th class="tableTitle">DateTime</th>
															</tr>
													  </thead>
													  <tbody id="f4current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI5f">
				                        <div class="f5_box" style="height:auto;" >
				                            <div id="f5_box_pct" style="position:relative;position:fixed;" >
				                            
				                            </div>

				                            <div class="tablef5" style="width:100%;margin-top:530px;height:auto;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Temperature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">SensorStatus</th>
																<th class="tableTitle">DateTime</th>
															</tr>
													  </thead>
													  <tbody id="f5current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI6f">
				                        <div class="f6_box" style="height:auto;">
				                            <div id="f6_box_pct" style="position:relative;position:fixed;" >
				                            
				                            </div>

				                            <div class="tablef6" style="width:100%;margin-top:530px;height:auto;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Temperature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">SensorStatus</th>
																<th class="tableTitle">DateTime</th>
															</tr>
													  </thead>
													  <tbody id="f6current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI7f">
				                        <div class="f7_box" style="height:auto;" >
				                            <div id="f7_box_pct" style="position:relative;position:fixed;" >
				                            
				                            </div>

				                            <div class="tablef7" style="width:100%;margin-top:530px;height:auto;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Temperature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">SensorStatus</th>
																<th class="tableTitle">DateTime</th>
															</tr>
													  </thead>
													  <tbody id="f7current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane active " id="CI8f">
				                        <div class="f8_box" style="height:auto;">
				                            <div id="f8_box_pct" style="position:relative;position:fixed;" >
				                            
				                            </div>

				                            <div class="tablef8" style="width:100%;margin-top:530px;height:auto;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead id="tableThead">
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Temperature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">SensorStatus</th>
																<th class="tableTitle">DateTime</th>
															</tr>
													  </thead>
													  <tbody id="f8current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI9f">
				                        <div class="f9_box" style="height:auto;">
				                            <div id="f9_box_pct" style="position:relative;position:fixed;" >
				                            
				                            </div>

				                            <div class="tablef9" style="width:100%;margin-top:530px;height:auto;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Temperature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">SensorStatus</th>
																<th class="tableTitle">DateTime</th>
															</tr>
													  </thead>
													  <tbody id="f9current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>
								</div>
						</div> 
		          	</div>
		        </div>
		</div>

	</div>
<div id="CXShowHidebtn" ><button style="background-color:#EA700E;border-top: 1px solid #FFFFFF;border-left: 1px solid #FFFFFF;border-bottom: 1px solid #fff;border-right: 1px solid #fff;width:30px;height:30px;border-radius:50% 50%;margin-top:10px;"></button></div>
<nav id="CXFixFr" class="navbar-fixed-bottom " style="background-color:#399;height:70px;">
<ul id="CiLibfloor" class="nav nav-tabs cxli_fr" style="width:1300px;font-size:1.57em;margin-left:auto;margin-right: auto;margin-top: 10px;font-weight:700;font-family:微软雅黑;background-color:#399;" >
		      
		                            <li role="presentation"  onclick="infoshow(1)" ><a href="#CI1f" aria-controls="CI1f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆一楼</a></li>
		                          	<li role="presentation"  onclick="infoshow(2)" ><a href="#CI2f" aria-controls="CI2f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆二楼</a></li> 
		                            <li role="presentation"  onclick="infoshow(3)" ><a href="#CI3f" aria-controls="CI3f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆三楼</a></li>
		                            <li role="presentation"  onclick="infoshow(4)" ><a href="#CI4f" aria-controls="CI4f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆四楼</a></li>
		                            <li role="presentation"  onclick="infoshow(5)" ><a href="#CI5f" aria-controls="CI5f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆五楼</a></li>
		                            <li role="presentation"  onclick="infoshow(6)" ><a href="#CI6f" aria-controls="CI6f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆六楼</a></li>
		                            <li role="presentation"  onclick="infoshow(7)" ><a href="#CI7f" aria-controls="CI7f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆七楼</a></li>
		                            <li role="presentation"  class="active" onclick="infoshow(8)" ><a href="#CI8f" aria-controls="CI8f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆八楼</a></li>
		                            <li role="presentation"  onclick="infoshow(9)" ><a href="#CI9f" aria-controls="CI9f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆九楼</a></li> 
		                        </ul>
</nav>	
</body>

</html>