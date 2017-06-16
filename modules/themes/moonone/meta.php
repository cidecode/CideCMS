<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php $options->site_title(); ?></title>
		<meta name="keywords" content="" />
		<meta name="description" content="<?php echo $options->site_desc(); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo $theme->theme_root()."/"; ?>shine.css" />
		<link rel="stylesheet" type="text/css" href="lib/magnific-popup.css" />
		<script type="text/javascript" src="lib/jquery.min.js"></script>
		<script type="text/javascript" src="lib/jquery.magnific-popup.min.js"></script>
		<script type="text/javascript" src="lib/jquery.cycle2.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){

			/*
			 * Drop down menu
			 */
			$(".sub-menu").hide();
			$("#nav ul li").hover(
				function(){
					$(this).find(".sub-menu").stop(true,true).slideDown(100);
				},
				function(){
					$(this).find(".sub-menu").stop(true,true).slideUp(100);
				}
			);
		</script>
	</head>