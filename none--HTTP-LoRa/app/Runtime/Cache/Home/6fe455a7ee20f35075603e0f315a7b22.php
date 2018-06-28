<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />  
<meta name="viewport" content="width:1400px, initial-scale=1.0, maximum-scale=1.0"/>
<title>节点信息查询-ACTL</title>
<link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
<link href="/HTTP-Zigbee/app/Public/Monitor/css/TempAndHumidity.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/HTTP-Zigbee/app/Public/Monitor/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/HTTP-Zigbee/app/Public/Monitor/js/jquery.min.js"></script> 
<script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/HTTP-Zigbee/app/Public/Monitor/js/infoCheck.js"></script>
</head>

<body >
	<div  style="width:1400px;margin:0 auto;height:auto;" >
		<div class="CIheader" style="width:100%;min-width:1200px;height:30px">
	            <div class="container" >
	            	<div class="row" >
		                <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation" style="background-color:#399;opacity:0.85; border:0px; height:10px;">
		                  <!-- <div class="header-logo"> -->
		                    <div class="navbar-header " style="height:30px;">
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
		                          <li style="width:330px; height:50px; text-align:center;"><a  style=" font-size: 16px;color: #fff;">图书馆温湿度节点信息查询</a>
		                          </li>
		                          <li class="active"></li>
		                    </div>

		                  </nav>      
	                </div>
	             </div><!-- 控件结束-->

		</div>	<!--header结束-->
		<div class="CImainbody" style="width:100%;min-width:1200px;height:auto;">
			 <div class="container" style="width:100%;margin-top:60px;" >
		            <div class="row">
		                <div class="span6">
		                        <ul id="CiLibfloor" class="nav nav-tabs" style="width:100%;font-size:1.6em;font-weight:800;" >
		      
		                            <li role="presentation"  onclick="infoshow(1)" ><a href="#CI1f" aria-controls="CI1f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆一楼</a></li>
		                          	<li role="presentation"   onclick="infoshow(2)" ><a href="#CI2f" aria-controls="CI2f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆二楼</a></li> 
		                            <li role="presentation"  onclick="infoshow(3)" ><a href="#CI3f" aria-controls="CI3f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆三楼</a></li>
		                            <li role="presentation"  onclick="infoshow(4)" ><a href="#CI4f" aria-controls="CI4f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆四楼</a></li>
		                            <li role="presentation"  onclick="infoshow(5)" ><a href="#CI5f" aria-controls="CI5f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆五楼</a></li>
		                            <li role="presentation"  onclick="infoshow(6)" ><a href="#CI6f" aria-controls="CI6f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆六楼</a></li>
		                            <li role="presentation"  onclick="infoshow(7)" ><a href="#CI7f" aria-controls="CI7f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆七楼</a></li>
		                            <li role="presentation"  class="active" onclick="infoshow(8)" ><a href="#CI8f" aria-controls="CI8f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆八楼</a></li>
		                            <li role="presentation"  onclick="infoshow(9)" ><a href="#CI9f" aria-controls="CI9f" role="tab" data-toggle="tab" style="color:#9cf;">图书馆九楼</a></li> 
		                        </ul>
		            			<!--table panes-->
					            <div  class="tab-content" style="width:100%;height:1000px; margin-top:20px;">
					            <!--图书馆一楼布局页面-->
				                    <div role="tabpanel"  class="tab-pane " id="CI1f">
								        <div class="f1_box" ><!--style="background-color:#9cf;"-->

				                            <div id="f1_box_pct" style="position:relative;" >
				                            
				                            </div>
				   
				                            <div class="tablef1" style="width:100%;margin-top:30px;height:400px;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Tempreature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">DateTime</th>

															</tr>
													  </thead>
													  <tbody id="f1current_data"></tbody>
												</table>				                              
				                            </div> 
				                            
				                        </div>

                    				</div>

				                    <div role="tabpanel"  class="tab-pane " id="CI2f">
				                        <div class="f2_box" >
				                            <div id="f2_box_pct" style="position:relative;" >
				                            
				                            </div>

				                            <div class="tablef2" style="width:100%;margin-top:30px;height:400px;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Tempreature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">DateTime</th>

															</tr>
													  </thead>
													  <tbody id="f2current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>

				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI3f">
				                       <div class="f3_box" >
				                            <div id="f3_box_pct" style="position:relative;" >
				                            
				                            </div>

				                            <div class="tablef3" style="width:100%;margin-top:30px;height:400px;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Tempreature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">DateTime</th>

															</tr>
													  </thead>
													  <tbody id="f3current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI4f">
				                        <div class="f4_box" >
				                            <div id="f4_box_pct" style="position:relative;" >
				                            
				                            </div>

				                            <div class="tablef4" style="width:100%;margin-top:30px;height:400px;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Tempreature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">DateTime</th>

															</tr>
													  </thead>
													  <tbody id="f4current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI5f">
				                        <div class="f5_box" >
				                            <div id="f5_box_pct" style="position:relative;" >
				                            
				                            </div>

				                            <div class="tablef5" style="width:100%;margin-top:30px;height:400px;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Tempreature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">DateTime</th>

															</tr>
													  </thead>
													  <tbody id="f5current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI6f">
				                        <div class="f6_box" >
				                            <div id="f6_box_pct" style="position:relative;" >
				                            
				                            </div>

				                            <div class="tablef6" style="width:100%;margin-top:30px;height:400px;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Tempreature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">DateTime</th>

															</tr>
													  </thead>
													  <tbody id="f6current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI7f">
				                        <div class="f7_box" >
				                            <div id="f7_box_pct" style="position:relative;" >
				                            
				                            </div>

				                            <div class="tablef7" style="width:100%;margin-top:30px;height:400px;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Tempreature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">DateTime</th>

															</tr>
													  </thead>
													  <tbody id="f7current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane active " id="CI8f">
				                        <div class="f8_box">
				                            <div id="f8_box_pct" style="position:relative;" >
				                            
				                            </div>

				                            <div class="tablef8" style="width:100%;margin-top:30px;height:auto;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead id="tableThead">
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Tempreature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
																<th class="tableTitle">DateTime</th>

															</tr>
													  </thead>
													  <tbody id="f8current_data"></tbody>
												</table>				                              
				                            </div> 
      
                            			</div>
				                    </div>

				                    <div role="tabpanel"  class="tab-pane " id="CI9f">
				                        <div class="f9_box" >
				                            <div id="f9_box_pct" style="position:relative;" >
				                            
				                            </div>

				                            <div class="tablef9" style="width:100%;margin-top:30px;height:400px;background-color:#399;">
												<table class="table table-bordered table-striped">
									                  <thead>
															<tr>
																<th class="tableTitle">Sensor</th>
																<th class="tableTitle">Tempreature(℃)</th>
																<th class="tableTitle">Humidity(%RH)</th>
																<th class="tableTitle">BatteryStatus</th>
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
</body>

</html>