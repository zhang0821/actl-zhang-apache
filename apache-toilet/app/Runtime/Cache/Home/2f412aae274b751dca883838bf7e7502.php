<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="/apache-toilet/app/Public/Monitor/css/login.css">
</head>
<body>
	<div class="form-container">
		<p class="form-header"></p>
		<form action='../app/index.php/Home/Monitor/login', method='POST', align='center'><!-- "<?php echo U('Inquire/index');?>" -->
			<table>
				<tr>
					<td>
						<lable for='user'>account</lable>
					</td>
					<td><input id='user' type="text" name='login_username'></td>
				</tr>
				<tr>
					<td>
						<lable for='pwd'>password</lable>
					</td>
					<td><input id="pwd" type='password', name='login_password'></td>
				</tr>
				<tr>
					<td colspan='2', align='right'>
						<input type="submit"  value="login">
					</td>
				</tr>
				
			</table>
		</form>
		<p>msg</p><!---->
	</div>

</body>
</html>