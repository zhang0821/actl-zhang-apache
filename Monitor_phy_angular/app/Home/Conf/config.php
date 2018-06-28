<?php
return array(
	//'配置项'=>'配置值'
	// 页面调试
	// 'SHOW_PAGE_TRACE'       =>  true,//右下角显示页面信息
	// 资源目录定义
	'TMPL_PARSE_STRING'		=>	array('__PUBLIC__'=>'/Monitor_phy_angular/app'),
	
	'TMPL_CACHE_ON'   => false, 
	'HTML_CACHE_ON'   =>false,

/**/
	'CRON_CONFIG_ON'  =>true,//开启自动运行
	'CRON_CONFIG'     => array(   
        '测试执行定时任务' => array('Home/Index/store_value_interval', '600', ''),
        //路径(格式同R)、间隔秒（0为一直运行）、指定一个开始时间 
    ),  


	// 添加数据库配置信息
	'DB_LoRaWan'	=>array(
		'DB_TYPE'   			=>	'mysql', 		// 数据库类型
		'DB_HOST'   			=> 	'localhost', 	// 服务器地址
		'DB_NAME'   			=> 	'lora_monitor', // 数据库名
		'DB_USER'   			=> 	'root', 		// 用户名
		'DB_PWD'    			=> 	'zhang', 	// 密码
		'DB_PORT'   			=> 	 3306, 			// 端口
		'DB_PREFIX'	 			=> 	'', 		    // 数据库表前缀
		'DB_CHARSET'           	=>  'utf8',      	// 数据库编码
		),

	'DB_Local'	=>array(
		'DB_TYPE'   			=>	'pgsql', 		 // 数据库类型
		'DB_HOST'   			=> 	'127.0.0.1',  // 服务器地址
		'DB_NAME'   			=> 	'loraserver', 	 // 数据库名
		'DB_USER'   			=> 	'postgres', 	 // 用户名
		'DB_PWD'    			=> 	'dbpassword', 	 // 密码
		'DB_PORT'   			=> 	 5432, 			 // 端口
		'DB_PREFIX'	 			=> 	'', 		     // 数据库表前缀
		'DB_CHARSET'           	=>  'utf8',      	 // 数据库编码
		),
	
	// 配置邮件发送服务器
    // 配置邮件发送服务器
    'MAIL_HOST' =>'smtp.163.com',                       //smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE,                             //启用smtp认证
    'MAIL_USERNAME' =>'15623053086@163.com',            //你的邮箱名
	'MAIL_PASSWORD' =>'actl520',                        //163邮箱发件人授权密码
	'MAIL_FROM' =>'15623053086@163.com',                //发件人邮箱地址
	'MAIL_FROMNAME'=>'华中师范大学ACTL实验室',          //发件人姓名
	'MAIL_CHARSET' =>'utf-8',                           //设置邮件编码
	'MAIL_ISHTML' =>TRUE,                               // 是否HTML格式邮件
);
?>
