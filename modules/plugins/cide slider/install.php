<?php 
/**
 * Installation file for Cide Slider plugin
 */

function install_plugin(){
	global $c;

	$dmp="CREATE TABLE IF NOT EXISTS cm_cideslider (
	  	 cs_id int(11) NOT NULL AUTO_INCREMENT,
	  	 link varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  	 active tinyint(1) NOT NULL DEFAULT 1,
	  	 slide_order int(11) NOT NULL DEFAULT 0,
	  	 PRIMARY KEY (cs_id)
		 ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";

	if($c->query($dmp)) return true;
	else return false;

}

?>