<?php

# This file is loading something very important
require('load.php');

# Check user permission
$permission->perm_check_up($permission->frlr,$permission->frlw,'index','');

# Loading some more important informations
# Include log in lib
require('classes/register.php');

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Register - <?php $options->site_title(); ?></title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link rel="stylesheet" type="text/css" href="lib/is.css" />
		<script type="text/javascript" src="lib/jquery.min.js"></script>
		<script type="text/javascript" src="lib/jquery-ui.min.js"></script>
	</head>
	<body>
		<script type="text/javascript">
		$(document).ready(function(){
			// Message system 
			<?php 
				require('panel/classes/messages.php');
				$messages->ShowMsg(); 
			?>

		});
		</script>
		
		<div id="login-body">

			<img src="lib/img/ccpen.png" alt="" />
			<form method="post" action="<?php echo $constants->cwd."?hu=".$register->host_pg; ?>">
				<span>Username</span><br />
				<input class="input" type="text" name="nu_username" /><br />
				<span>Password</span><br />
				<input class="input" type="password" name="nu_password" /><br />
				<span>Email</span><br />
				<input class="input" type="text" name="nu_email" /><br /><br />
				<div id="message-s"></div>
				<div id="message-f"></div>	
				<input type="submit" name="reg_btn" value="Register" /><br /><br />
				<a href="<?php echo $options->site_host()."/login.php"; ?>">Go back to login</a><br />
				<a href="<?php echo $options->site_host(); ?>">Go back to site</a><br />
			</form>			
		</div>
	</body>
</html>