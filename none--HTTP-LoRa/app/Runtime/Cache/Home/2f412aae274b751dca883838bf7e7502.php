<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/HTTP-LoRa/app/Public/Monitor/css/loraMonitor.css" type="text/css" />
<script type="text/javascript" src="/HTTP-LoRa/app/Public/Monitor/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/HTTP-LoRa/app/Public/Monitor/js/jquery.min.js"></script>     
<title>LoRa环境监测系统</title>
</head>
<body>
	<script type="text/javascript">
var apache_test=function(){
	$.ajax({
		type: 'POST',
		url: "../app/index.php/Home/Index/apache_test",
		dataType: "json",
		success: function(data){
			console.log("apache test info log��"+data);
		}	
	});
}
//setInterval(apache_test,10000);
apache_test();

	</script>
</body>
</html>