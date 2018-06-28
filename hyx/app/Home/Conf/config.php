<?php
return array(
	//'配置项'=>'配置值'
	// 页面调试
	//'SHOW_PAGE_TRACE'       =>  true,
	// 资源目录定义
	'TMPL_PARSE_STRING'		=>	array('__PUBLIC__'=>'/hyx/app/Public/Monitor'),
	
	// 添加数据库配置信息
'DB_Local'	=>array(
		'DB_TYPE'   			=>	'pgsql', 		 // 数据库类型
		'DB_HOST'   			=> 	'10.191.190.28',  // 服务器地址
		'DB_NAME'   			=> 	'loraserver', 	 // 数据库名
		'DB_USER'   			=> 	'postgres', 	 // 用户名
		'DB_PWD'    			=> 	'dbpassword', 	 // 密码
		'DB_PORT'   			=> 	 5432, 			 // 端口
		'DB_PREFIX'	 			=> 	'', 		     // 数据库表前缀
		'DB_CHARSET'           	=>  'utf8',      	 // 数据库编码
		),

);