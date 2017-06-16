<?php

/**
 * This class is for tracking system logs.
 * Parm $what = category,post,page,etc..
 * Parm $data = Item name
 * Parm $action = INSERT,UPDATE,DELETE,etc..
 * Example: logs('category','News','DELETE');
 */

class Tracking
{
	public function logs($what,$data,$action)
	{ 
		$what=trim(strtolower($what));
		$action=trim(strtoupper($action));
		# Log creation date
		$log_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
		global $c;
		global $sessions;

		$dmp="INSERT INTO cm_tracking
			VALUES(
				'',
				$sessions->s_user_id,
				\"$what:$data\",
				$log_date,
				\"$action\")";
		if($c->query($dmp))
		{
			return true; 
		}
		else 
		{
			 return false; 
		}
	}
}

# Try to create Tracking object
try
{
	$tracking = new Tracking();
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>