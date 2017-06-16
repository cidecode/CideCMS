<?php 

/*
* CONFIG FILE
* Setting up the main configuration
* NOTICE: Please do not change this file if you don't know what are you doing.
*		  Otherwise your CMS won't work smoothly.
*/

# Root path
define('ROOT_PATH','.');

# Admin path
define('ADM_PATH','.'.ROOT_PATH.'/panel');

# Media path
define('MEDIA_PATH',ROOT_PATH.'/media');

# Media thumb path
define('THUMB_DIR','thumb');

# Image path
define('IMG_PATH',ROOT_PATH.'/img');

# Panel JavaScript path
define('P_JS_PATH',ADM_PATH.'/js');

# Modules path
define('MODULE_PATH',ROOT_PATH.'/modules');

# Theme path
define('THEME_PATH',MODULE_PATH.'/themes');

# Plugin path
define('PLUGIN_PATH',MODULE_PATH.'/plugins');

# Logo image file size (KB)
define('LOGO_MAX_SIZE',1024);

# Max text file size (KB)
# You can change this value but be careful
# Notice: must be specified in KiloBytes = KB
define('TXT_MAX_SIZE',2048);

# Max image file size (KB)
# You can change this value but be careful
# Notice: must be specified in KiloBytes = KB
define('IMG_MAX_SIZE',2048);

# Max audio file size (KB)
# You can change this value but be careful
# Notice: must be specified in KiloBytes = KB
define('AUD_MAX_SIZE',7168);

# Max video file size (MB)
# You can change this value but be careful
# Notice: must be specified in MegaBytes = MB
define('VID_MAX_SIZE',10);

# Max application file size (MB)
# You can change this value but be careful
# Notice: must be specified in MegaBytes = MB
define('APP_MAX_SIZE',20);

# Articles per page (Admin panel) - define this in a function
define('ITEMS_PER_PAGE',15);

# Current page you are at 
$cwd=$_SERVER['PHP_SELF'];

?>