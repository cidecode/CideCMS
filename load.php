<?php 
ob_start();
# Start sessions
session_start();

/*
 * This file is loading something very important
 * Do not delete or change this file
 */

require('classes/constants.php');
require('dbconfig.php');
require('classes/database.php'); 

// If database is not installed go to install script
if(!$database->CheckInstallDB()) exit(header("Location: install/index.php")); 
else if($database->CheckInstallDB() && is_dir('install')) exit(header("Location: install/success.php"));

require('classes/theme.php');
require('classes/hosturi.php');
require('classes/secup.php');
require('classes/sessions.php'); 
require('classes/permission.php');
require('classes/options.php');
require('classes/deleteoldkeys.php');

require('classes/header.php');
require('classes/menu.php');
require('classes/pagination.php');
require('classes/widgets.php');
require('classes/footer.php');

# Post view
if($options->ContentCheck('post'))
{ 
	require('classes/postview.php'); 
	require('lib/protect_confirm.inc'); 
	if($pview->cm == 1) 
		{ 
			require('classes/comments.php'); 
		}
}

# Page view
elseif($options->ContentCheck('page')){ 
	require('classes/pageview.php'); 
	require('lib/protect_confirm.inc'); 
	if($pview->cm == 1) 
		{ 
			require('classes/comments.php'); 
		}
}

# User view
elseif($options->ContentCheck('user')) 
{
	require('classes/userview.php');
}

# User view
elseif($options->ContentCheck('category'))
{ 
	require('classes/catview.php');
}

# Search view view
elseif($options->ContentCheck('search'))
{
	require('classes/searchview.php');
}

# Panel 
elseif($options->ContentCheck('panel'))
{
	require('panel/classes/tracking.php');
}

# Home view
else
{
	require('classes/home.php');
}

# Redirect host url to correct address
$host_uri->www_redirect();

# Check if site is under moderation
$options->site_under_mod();

# Delete old forgoten keys
$deleteoldkeys->Run();

?>