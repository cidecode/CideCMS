<?php 
ob_start();

require('../classes/constants.php');
require('../classes/hosturi.php');
require('../dbconfig.php');
require('../classes/database.php'); 
require('../classes/secup.php');
require('runscript.php');

# Redirect host url to correct address
$host_uri->www_redirect();

# Check input data
$error = $run->CheckInput();

// If database is not installed go to install script
//if(!$database->CheckInstallDB() && basename(__DIR__) != 'install') exit(header("Location: install/index.php")); 

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Installing CideCMS</title>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<link rel="stylesheet" type="text/css" href="is.css" />
	</head>
	<body>
		<div id="form-body">
			<img src="../lib/img/ccpen.png" alt="" />
			<p>You are about to install CideCMS on your host. Please fill all required fields to procced!</p>
			<form method="post" action="<?php echo $constants->cwd; ?>">
				<span>Admin name</span><br />
				<input class="input" type="text" name="admin_name" /><br />
				<span>Admin password</span><br />
				<input class="input" type="password" name="admin_passwd" /><br />
				<span>Admin email</span><br />
				<input class="input" type="email" name="admin_email" /><br />
				<span>Site name</span><br />
				<input class="input" type="text" name="site_name" /><br />
				<span>Site description</span><br />
				<input class="input" type="text" name="site_desc" /><br />
				<span>Site host</span><br />
				<input class="input" type="text" name="site_host" value="<?php $run->SiteRootFolder(); ?>" /><br />
				<input type="submit" name="install" value="Install" />
				<input type="reset" value="Reset" />
			</form>	
			<?php if(isset($error) && $error != '') echo $error; ?>		
		</div>
	</body>
</html>
<?php ob_end_flush(); ?>