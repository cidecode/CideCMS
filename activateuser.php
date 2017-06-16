<?php


# This file is loading something very important
require('load.php');

# Check user permission
$permission->perm_check_up($permission->frlr,$permission->frlw,'index','');

# Include log in lib
include('classes/activateuser.php');

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Activate your account - <?php $options->site_title(); ?></title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link rel="stylesheet" type="text/css" href="lib/is.css" />
		<script type="text/javascript" src="panel/jquery.min.js"></script>
		<script type="text/javascript" src="panel/jquery-ui.min.js"></script>
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
			<div id="message-s"></div>
			<div id="message-f"></div><br />
			<a href="<?php echo $options->site_host()."/login.php"; ?>">Login</a><br />
			<a href="<?php echo $options->site_host(); ?>">Go back to site</a><br />			
		</div>
	</body>
</html>

