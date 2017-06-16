<?php

/*
* Configuration file that contains some predefined constants.
* NOTICE TO NOOBIES (NOTNO): Do not change this file if you don't know
* 					 		 what are you doing. The CMS could not work
*					 		 properly.
*/

class Constants
{
	# Root path
	const ROOT_PATH = '.';

	# Admin path
	const ADM_PATH = '.'.self::ROOT_PATH.'/panel';

	# Media path
	const MEDIA_PATH = '.'.self::ROOT_PATH.'/media';

	# Backup path
	const BACKUP_PATH = '.'.self::ROOT_PATH.'/backups';

	# Media thumb path
	const THUMB_DIR = 'thumb';

	# Image path
	const IMG_PATH = '.'.self::ROOT_PATH.'/img';

	# Panel JavaScript path
	const P_JS_PATH = '.'.self::ADM_PATH.'/js';

	# Modules path
	const MODULE_PATH = self::ROOT_PATH.'/modules';

	# Theme path
	const THEME_PATH = self::MODULE_PATH.'/themes';

	# Plugin path
	const PLUGIN_PATH = self::MODULE_PATH.'/plugins';

	# Logo image file size (KB)
	const LOGO_MAX_SIZE = 1024;

	# Max text file size (KB)
	# You can change this value but be careful
	# Notice: must be specified in KiloBytes = KB
	const TXT_MAX_SIZE = 2048;

	# Max image file size (KB)
	# You can change this value but be careful
	# Notice: must be specified in KiloBytes = KB
	const IMG_MAX_SIZE = 2048;

	# Max audio file size (KB)
	# You can change this value but be careful
	# Notice: must be specified in KiloBytes = KB
	const AUD_MAX_SIZE = 7168;

	# Max video file size (MB)
	# You can change this value but be careful
	# Notice: must be specified in MegaBytes = MB
	const VID_MAX_SIZE = 10;

	# Max application file size (MB)
	# You can change this value but be careful
	# Notice: must be specified in MegaBytes = MB
	const APP_MAX_SIZE = 20;

	# Articles per page (Admin panel) - define this in a function
	const ITEMS_PER_PAGE = 15;

	# Current working directory (page) you are at 
	public $cwd;

	public function __construct()
	{
		$this->cwd = $_SERVER['PHP_SELF'];
	}

}

$constants = new Constants();

?>