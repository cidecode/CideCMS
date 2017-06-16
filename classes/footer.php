<?php 

/*
 * This class is for displaying footer data.
 */

class Footer
{
	# Grab the navigation items
	public function grab_footer(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name='site_footer'";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$ech="<p>".$r['option_value']."</p>";
				break;
			}
		}
		mysqli_free_result($d);
		return $ech;
	}	
}

# Try to create Footer object
try
{
	$footer = new Footer();
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>