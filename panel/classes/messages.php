<?php

/*
 * This is a class for showing messages
 * Here we must call msgcodes.php
 */

require('msgcodes.php');

class Messages
{
	public function ShowMsg()
	{
		global $msg;
		
		if(isset($_GET['m']))
		{
			$m = intval($_GET['m']);
				
			$mi = $msg[$m];

			if($m < 100) $sm = 1;
			else $sm = 2;

			# jQuery showing system
			if($sm == 1){ 
				echo "$('#message-s').show().text(\"$mi\");";
			}
			else if($sm == 2){
				echo "$('#message-f').show().text(\"$mi\");";
			}
			else{
				echo "$('#message-s').hide();";
				echo "$('#message-f').hide();";
			} 
		}
	}
}

# Try to create Messages object
try	
{
	$messages = new Messages();
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>