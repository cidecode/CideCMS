<?php


# This file is loading something very important

require('load.php');



# Check user permission
$permission->perm_check_up($permission->frlr,$permission->frlw,'index','');

# Include log in lib
require('classes/login.php');

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Log in - <?php $options->site_title(); ?></title>
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
			<form method="post" action="<?php echo $constants->cwd."?hu=$login->host_pg"; ?>">
				<span>Username</span><br />
				<input class="input" type="text" name="ur_nm" /><br />
				<span>Password</span><br />
				<input class="input" type="password" name="ur_ps" /><br /><br />
				<div id="message-s"></div>
				<div id="message-f"></div>	
				<input type="submit" name="login" value="Log in" /><br /><br />
				<a href="<?php echo $options->site_host()."/forgetpassword.php"; ?>">Forgot your password?</a><br />
				<a href="<?php echo $options->site_host(); ?>">Go back to site</a><br /><br />
				<a href="<?php echo $options->site_host()."/register.php?hu=".$host_uri->host_uri_noparm(); ?>"><b>New user? Register here</b></a><br />
			</form>		
		</div>
	</body>	
</html>

