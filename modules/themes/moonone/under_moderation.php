<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Site is under moderation - <?php $options->site_title(); ?></title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link rel="stylesheet" type="text/css" href="lib/is.css" />
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
		<div id="message-s"></div>
		<div id="message-f"></div>	
		<div id="undermod-body">
			<?php $header->grab_logo_or_text(); ?>
			<p>SITE IS UNDER MODERATION, PLEASE COME BACK LATER!</p>
			<a href="login.php">Log in</a>		
		</div>
	</body>
</html>