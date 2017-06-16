<?php 

/*
 * This is a class that grabs header information
 * from database.
 */

class Header
{
	private $glot;

	public function __construct(){
		global $c;
		global $options;

		$this->glot=""; 

		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"site_logo\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_assoc()){
				$this->glot="<img src=\"".$r['option_value']."\" alt=\"".$options->site_name()."-".$options->site_desc()."\" />";
				break;
			}
			if($r['option_value'] == NULL){
				$this->glot="<h1 style=\"margin-top: 15px;\">".$options->site_name()."</h1>".$options->site_desc();
			}
		} else $this->glot = "dddd";
		mysqli_free_result($d);
	}

	public function grab_logo_or_text()
	{
		return $this->glot;
	}	
}

# Try to create Header object
try
{
	$header = new Header();
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>