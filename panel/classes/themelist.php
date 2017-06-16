<?php 

/*
 * This is a class for displaying themes.
 */

class ThemeList
{
	public $pca;
	public $pagwr;
	public $thlst;

	public function __construct()
	{
		$this->CheckPerm();
		$this->thlst = $this->GrabThemeList();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->bthr == 0){
			exit(header("Location: index.php"));
		}
	}

	// SQL dumping
	private function CurrentTheme()
	{
		global $c;

		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"site_theme\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$st=$r['option_value'];
				$d->free_result();
				break;
			}
			return $st;
		}
	}

	// Change main theme
	public function ChangeTheme($thm_name)
	{
		global $c;

		// SQL dumping
		$dmp="UPDATE cm_options SET option_value=\"$thm_name\" WHERE option_name=\"site_theme\"";

		if($c->query($dmp)){
			exit(header("Location: themes.php?m=15"));
		}
		else{
			exit(header("Location: themes.php?m=123"));
		}
	}

	// Listing themes
	private function GrabThemeList()
	{
		global $constants;
		global $permission;
		global $host_uri;

		$td=".".$constants::THEME_PATH; 
		if(is_dir($td)){
			if($od = opendir($td)){
				$thlst="<div class=\"theme-table\">";
				$this->pca=0;

				while(($file = readdir($od)) !== false){
					if($file == "." || $file == "..") 
						continue;

					// Theme preview image
					$th_pre=$td."/".$file;

					$this->pca++;

					$thlst.="<div class=\"theme-box\">
					<img src=\"$th_pre/preview.png\" class=\"theme-preview\" alt=\"\" /><br />";

					// Read information from XML document
					if(file_exists("$th_pre/information.xml")){					

						$xml_info=simplexml_load_file("$th_pre/information.xml");

						$xml_name=$xml_info -> name;
						$xml_ver=$xml_info -> version;
						$xml_desc=$xml_info -> description;
						$xml_view=$xml_info -> preview;
						$xml_author=$xml_info -> author;
						$xml_email=$xml_info -> email;
						$xml_site=$xml_info -> site;

						$thlst.="<span class=\"info\">
								Name: <span title=\"$xml_desc\"><b>$xml_name</b></span><br />
								Version: $xml_ver<br />
								Author: <a href=\"$xml_site\">$xml_author</a><br />
								Email: $xml_email<br />
								</span>";
					}
					else{
						$thlst.="<span class=\"info\">Theme information does not exist.</span>";
					}

					// Check what theme is in usage
					if($this->CurrentTheme() == $file){
						$thlst.="<a href=\"themes.php\" class=\"theme-using\">In use</a>";
					}
					else{
						if($permission->bthw == 1){
							$thlst.="<a href=\"themes.php?n=$file&h=".$host_uri->host_uri()."\" class=\"theme-use\">Use this theme</a>";
						}
						else{
							$thlst.="<a href=\"themes.php\" class=\"theme-use\"><del>Use this theme</del></a>";
						}
					}
					if($permission->bthw == 1){
						$thlst.="<a href=\"delete.php?d=$file&t=theme&h=themes.php\" class=\"theme-del\">Delete</a>";
					}
					$thlst.="</div>";
				}

				$thlst.="</div>";

				closedir($od);

				return $thlst;
			}
		}
	}
	
}

# Try to create ThemeList object
try
{
	$themelist = new ThemeList();

	if(isset($_GET['n']))
	{
		$themelist->ChangeTheme($_GET['n']);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}



?>