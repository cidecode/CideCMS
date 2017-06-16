<?php 

/*
 * This class is for getting the active theme 
 * and creating the theme path.
 */

class Theme{

	private $page;
	private $thm_path;

	public function __construct($page)
	{
		$this->page = $page;
		$this->theme_path($this->page);
	}
	
	# Theme chooser
	public function site_theme(){
		# Grab site name from database
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name='site_theme'";
		$d=$c->query($dmp);
		$r=$d->fetch_array(MYSQLI_ASSOC);
		$ch=$r['option_value'];
		return $ch;
	}

	# Theme full path
	public function theme_path($a){
		global $constants;

		# Mix for theme path
		$ch=$this->site_theme();
		$path=$constants::THEME_PATH."/$ch/$a";
		
		$this->thm_path = $path;
	}

	# Theme root path
	public function theme_root(){
		global $constants;

		# Mix for theme path
		$ch=$this->site_theme();
		$path=$constants::THEME_PATH."/$ch/";
		
		return $path;
	}

	public function getThm_path()
	{
		return $this->thm_path;
	}
}


?>