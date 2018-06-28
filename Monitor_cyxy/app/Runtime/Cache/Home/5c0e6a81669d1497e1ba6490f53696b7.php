<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    
<head>
        <title>独居老人监护系统</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="/HTTP-Zigbee/app/Public/protected/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/HTTP-Zigbee/app/Public/protected/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="/HTTP-Zigbee/app/Public/protected/css/matrix-login.css" />
        <link href="/HTTP-Zigbee/app/Public/protected/font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link rel="stylesheet" href="/HTTP-Zigbee/app/Public/protected/css/googlefonts.css" />

    </head>
    <body>
        <div id="loginbox">            
            <form id="loginform" class="form-vertical" method="post" action="/HTTP-Zigbee/app/index.php/Login/check">
				 <div class="control-group normal_text"> <h3><img src="/HTTP-Zigbee/app/Public/protected/img/logo.png" alt="Logo" /></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"></i></span><input id="username" name="username" type="text" placeholder="Username" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input id="password" name="password" type="password" placeholder="Password" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
                    <span class="pull-right"><a type="submit" href="index.html" class="btn btn-success" /> Login</a></span>
                </div>
            </form>
            <form id="recoverform" action="#" class="form-vertical">
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input id="email" name="email"type="text" placeholder="E-mail address" />
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><a class="btn btn-info"/>Recover</a></span>
                </div>
            </form>
        </div>
        
        <script src="/HTTP-Zigbee/app/Public/protected/js/jquery.min.js"></script>  
        <script src="/HTTP-Zigbee/app/Public/protected/js/matrix.login.js"></script> 
		<script src="/HTTP-Zigbee/app/Public/protected/js/jquery.validate.js"></script>
		<script src="/HTTP-Zigbee/app/Public/js/login_validate.js"></script>
    </body>

</html>