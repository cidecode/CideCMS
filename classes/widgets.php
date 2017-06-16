<?php 

/*
 * This class is for displaying widgets.
 */

class Widgets
{
	public $aw;

	public function __construct()
	{
		$this->aw = $this->all_widgets();
	}
	
	private function all_widgets(){
		global $c;

		$dmp="SELECT wi_id as wi,title as tt,content as ct,active as ac
			  FROM cm_widgets 
	          WHERE active=1";
		if($d=$c->query($dmp)){
			return $d;
		}
		else{
			$sn="<can't grab widgets>";
			return false;
		}
		mysqli_free_result($d);
	}
}

# Try to create Widgets object
try
{
	$widgets = new Widgets();
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>