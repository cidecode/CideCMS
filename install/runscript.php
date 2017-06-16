<?php 

/*
 * This is a script for installing CideCMS system.
 * After installing please delete install folder from system.
 */

class RunScript
{
	public $ferr;

	public function SiteRootFolder()
	{
		$u='http://'.$_SERVER['SERVER_NAME'].''.$_SERVER['REQUEST_URI'];
		$a=explode('/',$u);
		$pw='';
		for($i=0; $i<count($a)-2; $i++)
		{ 
			if($i == count($a)-3) $pw.=$a[$i];
			else $pw.=$a[$i].'/';
		}
		echo $pw;
	}

	public function Install()
	{
		global $c;
		global $ss1;

		$admin_name=strtolower(trim($_POST['admin_name']));
		$admin_passwd=trim($_POST['admin_passwd']);
		$admin_email=strtolower(trim($_POST['admin_email']));
		$site_name=trim($_POST['site_name']);
		$site_desc=trim($_POST['site_desc']);
		$site_host=strtolower(trim($_POST['site_host']));
		$date=date("Y");
		$create_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

		# admin name check up
		$reg_admin_name="/^[\w\d]{3,20}$/";
		if(!preg_match($reg_admin_name,$admin_name)){
			exit(header("Location: index.php?err=a"));
		}

		# passwd check up
		$reg_admin_passwd="/^[a-zA-Z0-9\"\'\/\|\(\)\!\?\.\,\<\>\#\$\%\&\\\=\*\+\-]{5,15}$/";
		if(!preg_match($reg_admin_passwd,$admin_passwd)){
			exit(header("Location: index.php?err=p"));
		}
		else $admin_passwd=$ss1->shiftshell($admin_passwd);

		# email check up
		$reg_admin_email="/^[a-z0-9\-\.]{2,25}[a-z0-9]{1}\@[a-z0-9]{2,15}\.[a-z]{2,3}(\.[a-z]{1,3})?$/";
		if(!preg_match($reg_admin_email,$admin_email)){
			exit(header("Location: index.php?err=e"));
		}

		# site name check up
		$reg_site_name="/^[\w\d\s\"\'\-\.\,\:\;\_\/\(\)\[\]\&\%\#\$\?\!\@\{\}\|]{1,}$/";
		if(!preg_match($reg_site_name,$site_name)){
			exit(header("Location: index.php?err=sn"));
		}

		# site description check up
		$reg_site_desc="/^[\w\d\s\"\'\-\.\,\:\;\_\/\(\)\[\]\&\%\#\$\?\!\@\{\}\|]{1,}$/";
		if(!preg_match($reg_site_desc,$site_desc)){
			exit(header("Location: index.php?err=sd"));
		}

		# site host check up
		$reg_site_host="/^(http|https)\:\/\/(www.)?[a-z\d\-]{1,}(\.[a-z]{2,3})?(\.[a-z]{1,5})?(\/[a-zA-Z0-9\-\_]{1,})*$/";
		if(!preg_match($reg_site_host,$site_host)){
			exit(header("Location: index.php?err=sh"));
		}

		# 
		# Starting sql dumping
		# Don't change anything in this string or otherwise database design won't work as planed
		#

		# Conect to database for executing the sql dumping

		#$dmp_file = file_get_contents('db_install.sql', true);
		#$dmp = explode(';', $dmp_file);
		
		$dmp=[
		"SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\"",
		"SET time_zone = \"+00:00\"",

		"/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */",
		"/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */",
		"/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */",
		"/*!40101 SET NAMES utf8mb4 */",

		"CREATE TABLE `cm_category` (
		  `ca_id` int(11) NOT NULL,
		  `cat_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
		  `visible` tinyint(1) NOT NULL DEFAULT '1',
		  `active` tinyint(1) NOT NULL DEFAULT '1'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",

		"INSERT INTO `cm_category` (`ca_id`, `cat_name`, `visible`, `active`) VALUES
		(1, 'uncategorized', 1, 1)",

		"CREATE TABLE `cm_comments` (
		  `co_id` int(11) NOT NULL,
		  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `content` text COLLATE utf8_unicode_ci NOT NULL,
		  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `user_id` int(11) DEFAULT NULL,
		  `post_id` int(11) NOT NULL,
		  `create_date` int(11) NOT NULL,
		  `active` tinyint(1) NOT NULL DEFAULT '0'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",

		"INSERT INTO `cm_comments` (`co_id`, `full_name`, `content`, `email`, `user_id`, `post_id`, `create_date`, `active`) VALUES
		(1, \"$admin_name\", 'This is first comment on your site.', \"$admin_email\", 1, 1, $create_date, 1)",

		"CREATE TABLE `cm_forgetpasswd` (
		  `rp_id` int(11) NOT NULL,
		  `user_id` int(11) NOT NULL,
		  `forgetkey` varchar(255) NOT NULL,
		  `createdate` int(11) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1",

		"CREATE TABLE `cm_media` (
		  `me_id` int(11) NOT NULL,
		  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
		  `description` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `media_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
		  `media_size` int(11) NOT NULL,
		  `upload_date` int(11) NOT NULL,
		  `active` tinyint(1) NOT NULL DEFAULT '1'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",

		"INSERT INTO `cm_media` (`me_id`, `name`, `description`, `link`, `media_type`, `media_size`, `upload_date`, `active`) VALUES
		(1, 'logo.png', 'Big logo', \"$site_host/media/logo.png\", 'image/png', 17158, $create_date, 1)",

		"CREATE TABLE `cm_options` (
		  `op_id` int(11) NOT NULL,
		  `option_name` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
		  `option_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",

		"INSERT INTO `cm_options` (`op_id`, `option_name`, `option_value`) VALUES
		(1, 'site_name', \"$site_name\"),
		(2, 'site_description', \"$site_desc\"),
		(3, 'site_admin', '1'),
		(4, 'site_email', \"$admin_email\"),
		(5, 'site_logo', ''),
		(6, 'site_host', \"$site_host\"),
		(7, 'site_theme', 'moonone'),
		(8, 'site_footer', ''),
		(9, 'page_visits', '0'),
		(10, 'unique_visits', '0'),
		(11, 'under_mod', '0'),
		(12, 'articles_per_page', '10'),
		(13, 'comments', '1'),
		(14, 'main_perm', '6'),
		(15, 'tracking', '0'),
		(16, 'rss', '0'),
		(17, 'plugins', '1'),
		(18, 'sitemap', '0'),
		(19, 'db_backup', ''),
		(20, 'smtp_host', ''),
		(21, 'smtp_username', ''),
		(22, 'smtp_passwd', ''),
		(23, 'smtp_secure', ''),
		(24, 'smtp_port', ''),
		(25, 'smtp_send_as', '')",

		"CREATE TABLE `cm_plugins` (
		  `pl_id` int(11) NOT NULL,
		  `plugin_dir` varchar(255) NOT NULL,
		  `active` int(11) NOT NULL DEFAULT '0'
		) ENGINE=InnoDB DEFAULT CHARSET=latin1",

		"CREATE TABLE `cm_posts` (
		  `po_id` int(11) NOT NULL,
		  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `content` text COLLATE utf8_unicode_ci,
		  `author` int(11) NOT NULL,
		  `category` int(11) NOT NULL,
		  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `type` tinyint(1) NOT NULL DEFAULT '0',
		  `active` tinyint(1) NOT NULL DEFAULT '1',
		  `create_date` int(11) NOT NULL,
		  `modify_date` int(11) DEFAULT NULL,
		  `protect` tinyint(1) NOT NULL DEFAULT '0',
		  `parent` int(11) DEFAULT '0',
		  `comments` tinyint(1) NOT NULL DEFAULT '1'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",

		"INSERT INTO `cm_posts` (`po_id`, `title`, `content`, `author`, `category`, `link`, `type`, `active`, `create_date`, `modify_date`, `protect`, `parent`, `comments`) VALUES
		(1, 'This is your new site', '<img src=\"$site_host/media/logo.png\" alt=\"\" /><br />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quis ligula ipsum. Cras venenatis nibh a sem fermentum molestie. Integer orci sem, viverra eget consectetur scelerisque, elementum non dui. Nunc lacinia ac felis sit amet egestas. Pellentesque nec fringilla dolor, vel vehicula tortor. Donec aliquam placerat libero nec placerat. Morbi cursus arcu vel sem semper, quis vestibulum mauris cursus.\r\n\r\nCras sit amet turpis quis nunc rutrum porta at nec urna. Quisque at dictum enim. Ut congue dui nisi, scelerisque volutpat lorem tempus ac. Etiam sed dignissim urna, sed laoreet magna. Curabitur a orci malesuada, facilisis urna vitae, dignissim lorem. Donec fringilla enim sodales metus condimentum, in vulputate leo aliquet. Vestibulum adipiscing congue urna, id fermentum nisl suscipit in. Phasellus tincidunt vel massa quis facilisis.\r\n\r\nAliquam quis nisl elementum, hendrerit sem eleifend, feugiat enim. Morbi massa ante, dictum mattis sodales at, blandit at eros. Maecenas id eleifend nisl. Pellentesque facilisis metus nunc, quis posuere quam sodales ut. Integer eu quam pretium, lobortis neque egestas, accumsan lectus. Maecenas blandit non ante at faucibus. Praesent sit amet velit aliquam, posuere augue quis, venenatis ligula. Integer iaculis augue et dui placerat, a interdum elit fringilla. Praesent sodales lectus ac lacus rhoncus, id dictum lectus congue. Maecenas suscipit tincidunt dolor vestibulum tempor. Vivamus quam ante, suscipit eget erat et, pharetra auctor metus. Maecenas dignissim non nisi sit amet varius. Cras non orci placerat magna imperdiet pharetra vel a enim. Phasellus sagittis porttitor velit, sed dictum ligula ultrices nec. Nulla interdum lorem quis varius euismod. Nullam sed risus velit.', 1, 1, \"$site_host/page.php?a=1\", 0, 1, $create_date, $create_date, 0, 0, 1)",

		"CREATE TABLE `cm_protect` (
		  `pr_id` int(11) NOT NULL,
		  `post_id` int(11) NOT NULL,
		  `post_passwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",

		"CREATE TABLE `cm_tracking` (
		  `tr_id` int(11) NOT NULL,
		  `who` int(11) NOT NULL,
		  `what` text COLLATE utf8_unicode_ci NOT NULL,
		  `when` int(11) NOT NULL,
		  `action` varchar(50) COLLATE utf8_unicode_ci NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",

		"CREATE TABLE `cm_useractivation` (
		  `ua_id` int(11) NOT NULL,
		  `user_id` int(11) NOT NULL,
		  `activationkey` varchar(255) NOT NULL,
		  `creationdate` int(11) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1",

		"CREATE TABLE `cm_users` (
		  `us_id` int(11) NOT NULL,
		  `username` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
		  `passwd` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
		  `nickname` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `full_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `birth_date` int(11) DEFAULT NULL,
		  `join_date` int(11) NOT NULL,
		  `active` tinyint(1) DEFAULT '0',
		  `type` int(11) NOT NULL,
		  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",

		"INSERT INTO `cm_users` (`us_id`, `username`, `passwd`, `nickname`, `user_email`, `full_name`, `birth_date`, `join_date`, `active`, `type`, `avatar`) VALUES
		(1, \"$admin_name\", \"$admin_passwd\", \"$admin_name\", \"$admin_email\", \"$admin_name\", NULL, $create_date, 1, 1, NULL)",

		"CREATE TABLE `cm_userstatus` (
		  `ut_id` int(11) NOT NULL,
		  `status_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
		  `status_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
		  `user_perm` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'in:1,1;pg:1,1;ps:1,1;cm:1,1;ue:1,1;ct:1,1;rl:1,1/cp:0,0;pg:0,0;ps:0,0;ct:0,0;cm:0,0;md:0,0;ue:0,0;rl:0,0;te:0,0;ot:0,0;pu:0,0/dm:1,1'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",

		"INSERT INTO `cm_userstatus` (`ut_id`, `status_name`, `status_desc`, `user_perm`) VALUES
		(1, 'Administrator', 'Full control', 'in:1,1;pg:1,1;ps:1,1;cm:1,1;ue:1,1;ct:1,1;rl:1,1/cp:1,1;pg:1,1;ps:1,1;ct:1,1;cm:1,1;md:1,1;ue:1,1;rl:1,1;te:1,1;ot:1,1;pu:1,1/dm:1,1'),
		(2, 'Moderator', 'Control over articles and comments', 'in:1,1;pg:1,1;ps:1,1;cm:1,1;ue:1,1;ct:1,1;rl:1,1/cp:1,1;pg:1,1;ps:1,1;ct:1,1;cm:1,1;md:1,1;ue:1,1;rl:0,0;te:0,0;ot:0,0;pu:0,0/dm:1,1'),
		(3, 'Author', 'Control over their own articles and comments', 'in:1,1;pg:1,1;ps:1,1;cm:1,1;ue:1,1;ct:1,1;rl:1,1/cp:1,1;pg:0,0;ps:1,1;ct:1,1;cm:0,0;md:1,1;ue:0,0;rl:0,0;te:0,0;ot:0,0;pu:0,0/dm:1,1'),
		(4, 'User', 'Control over their own comments', 'in:1,1;pg:1,1;ps:1,1;cm:1,1;ue:1,1;ct:1,1;rl:1,1/cp:0,0;pg:0,0;ps:0,0;ct:0,0;cm:0,0;md:0,0;ue:0,0;rl:0,0;te:0,0;ot:0,0;pu:0,0/dm:1,1'),
		(5, 'Test', 'Testing permision, check up!', 'in:1,0;pg:1,0;ps:1,0;cm:0,0;ue:0,0;ct:0,0;rl:1,0/cp:0,0;pg:0,0;ps:0,0;ct:0,0;cm:0,0;md:0,0;ue:0,0;rl:0,0;te:0,0;ot:0,0;pu:0,0/dm:1,1'),
		(6, 'Visitor', 'Site visitors', 'in:1,1;pg:1,1;ps:1,1;cm:1,0;ue:1,0;ct:1,0;rl:1,1/cp:0,0;pg:0,0;ps:0,0;ct:0,0;cm:0,0;md:0,0;ue:0,0;rl:0,0;te:0,0;ot:0,0;pu:0,0/dm:1,1')",

		"CREATE TABLE `cm_widgets` (
		  `wi_id` int(11) NOT NULL,
		  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
		  `content` text COLLATE utf8_unicode_ci NOT NULL,
		  `active` tinyint(1) NOT NULL DEFAULT '1'
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",

		"INSERT INTO `cm_widgets` (`wi_id`, `title`, `content`, `active`) VALUES
		(1, 'Sidebar', 'This is your sidebar section.', 1)",

		"ALTER TABLE `cm_category`
  		ADD PRIMARY KEY (`ca_id`)",

		"ALTER TABLE `cm_comments`
  		ADD PRIMARY KEY (`co_id`),
  		ADD KEY `user_id` (`user_id`),
  		ADD KEY `post_id` (`post_id`)",

		"ALTER TABLE `cm_forgetpasswd`
  		ADD PRIMARY KEY (`rp_id`),
  		ADD KEY `user_id` (`user_id`)",

		"ALTER TABLE `cm_media`
  		ADD PRIMARY KEY (`me_id`)",

		"ALTER TABLE `cm_options`
  		ADD PRIMARY KEY (`op_id`)",

		"ALTER TABLE `cm_plugins`
  		ADD PRIMARY KEY (`pl_id`)",

		"ALTER TABLE `cm_posts`
  		ADD PRIMARY KEY (`po_id`),
  		ADD KEY `author` (`author`),
  		ADD KEY `category` (`category`),
  		ADD KEY `parent` (`parent`)",

		"ALTER TABLE `cm_protect`
  		ADD PRIMARY KEY (`pr_id`),
  		ADD KEY `post_id` (`post_id`)",

		"ALTER TABLE `cm_tracking`
  		ADD PRIMARY KEY (`tr_id`),
  		ADD KEY `who` (`who`)",

		"ALTER TABLE `cm_useractivation`
  		ADD PRIMARY KEY (`ua_id`),
  		ADD KEY `user_id` (`user_id`)",

		"ALTER TABLE `cm_users`
  		ADD PRIMARY KEY (`us_id`),
  		ADD KEY `type` (`type`)",

		"ALTER TABLE `cm_userstatus`
  		ADD PRIMARY KEY (`ut_id`)",

		"ALTER TABLE `cm_widgets`
  		ADD PRIMARY KEY (`wi_id`)",

  		"ALTER TABLE `cm_category`
  		MODIFY `ca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2",

  		"ALTER TABLE `cm_comments`
  		MODIFY `co_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2",

  		"ALTER TABLE `cm_forgetpasswd`
  		MODIFY `rp_id` int(11) NOT NULL AUTO_INCREMENT",

  		"ALTER TABLE `cm_media`
  		MODIFY `me_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2",

  		"ALTER TABLE `cm_options`
  		MODIFY `op_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26",

  		"ALTER TABLE `cm_plugins`
  		MODIFY `pl_id` int(11) NOT NULL AUTO_INCREMENT",

  		"ALTER TABLE `cm_posts`
  		MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2",

  		"ALTER TABLE `cm_protect`
  		MODIFY `pr_id` int(11) NOT NULL AUTO_INCREMENT",

  		"ALTER TABLE `cm_tracking`
  		MODIFY `tr_id` int(11) NOT NULL AUTO_INCREMENT",

  		"ALTER TABLE `cm_useractivation`
  		MODIFY `ua_id` int(11) NOT NULL AUTO_INCREMENT",

  		"ALTER TABLE `cm_users`
  		MODIFY `us_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2",

  		"ALTER TABLE `cm_userstatus`
  		MODIFY `ut_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7",

  		"ALTER TABLE `cm_widgets`
  		MODIFY `wi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2",

  		"/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */",
  		"/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */",
  		"/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */"

		];

		#$sdd;
		# Execute the sql dumping
		for($j=0; $j<count($dmp); $j++)
		{
			$d=$dmp[$j]; 
			#$sdd.=$d."<br /><br />";
			if($c->query($d))
			{
				$sdmp=true;
			}
			else
			{
				$sdmp=false;
				break;
			}
		}
		#die($sdd);
		if($sdmp)
		{
			exit(header("Location: ".$site_host."/install/success.php"));
		}
		else
		{
			exit(header("Location: ".$site_host."/install/index.php?err=i"));
			#die($d);
		}
	}

	public function CheckInput()
	{
		# check if installaton failed and grab the error code
		if(isset($_GET['err'])){
			$err=$_GET['err'];

			switch($err){
				case 'a':
					return "<br />Admin name is wrong. <i>Example: cmsuser</i>";
					break;
				case 'p':
					return "<br />Password is wrong. Enter between 5-15 chars.";
					break;
				case 'e':
					return "<br />Email address is wrong. <i>Example: user@domain.com</i>";
					break;
				case 'sn':
					return "<br />Site name is wrong. <i>Example: My first website</i>";
					break;
				case 'sd':
					return "<br />Site description is wrong. <i>Example: This is my first website</i>";
					break;
				case 'sh':
					return "<br />Site host is wrong. <i>Example: http://example.com</i>";
					break;
				case 'i':
					return "<br />Installation went wrong. Please contact your administrator or check parameters.";
					break;
				default: 
					return "<br />Some other error. Perhaps yours.";
					break;
			}
		}
		else return null;
	}
}

# Try to create RunScript object
try
{
	$run = new RunScript();

	if(isset($_POST['install']))
	{
		$run->Install();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>