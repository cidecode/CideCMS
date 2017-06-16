<?php 

 
require('lib/protection.inc'); 
//require('classes/protect.php');

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Password protected content - <?php $options->site_title(); ?></title>
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
				include('panel/classes/messages.php'); 
				$messages->ShowMsg();
			?>

		});
		</script>
		<div id="protected-body">
			<?php echo $header->grab_logo_or_text(); ?>
			<p class="big">THIS IS PASSWORD PROTECTED CONTENT!</p>
			<p>Protected content: <a href="<?php echo $ln; ?>"><?php echo $tt; ?></a></p><br /><br />
			<form method="post" action="<?php echo $pp; ?>">
				<span>Password</span><br />
				<input class="input" type="password" name="ps_protect" /><br /><br />
				<div id="message-s"></div>
				<div id="message-f"></div><br />
				<input type="submit" name="protect_confirm_btn" value="Confirm" /><br /><br />
				<a href="<?php echo $options->site_host(); ?>">Go back to site</a><br />
			</form>		
		</div>
	</body>
</html>