<?php 

/*
 * This is a class for displaying list of plugins
 */

class PluginList extends Pagination
{
	public $pca;
	public $pagwr;
	public $pllst;
	public $plugin_name;
	public $td;

	public function __construct()
	{
		$this->CheckPerm();
		$this->pllst = $this->GrabPluginList();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->bpur == 0){
			exit(header("Location: index.php"));
		}
	}	

	private function GrabPluginList()
	{
		global $constants;
		global $permission;
		global $host_uri;
		global $c;

		// Listing themes
		$this->td=".".$constants::PLUGIN_PATH;
		$pllst="";
		if(!isset($_GET['edit'])){ 
			if(is_dir($this->td)){
				if($od = opendir($this->td)){
					$pllst.="<table class=\"plugin-list\">
											<thead>
												<th>Name</th>
												<th>Description</th>
											</thead>
											<tbody>";
					$this->pca=0; 

					while(($file = readdir($od)) !== false){
						if($file == "." || $file == "..") 
							continue;

						// Theme preview image
						$th_pre=$this->td."/".$file;

						$this->pca++;

						$pllst.="<tr class=\"plrow\">";

						// Check if plugin is installed 
						$dmp="SELECT * FROM cm_plugins WHERE plugin_dir=\"$file\"";
						if($d=$c->query($dmp))
						{
							if($d->num_rows == 1) $plugin_installed = true;
							else $plugin_installed = false;
						}

						// Check if plugin is active or not
						$dmp="SELECT active as ac FROM cm_plugins WHERE plugin_dir=\"$file\"";
						if($d=$c->query($dmp))
						{
							if($r=$d->fetch_assoc()){
								if($r['ac'] == 0) $plugin_active=false;
								else $plugin_active=true;
							}
						}

						// Read information from XML document
						if(file_exists("$th_pre/information.xml")){					

							$xml_info=simplexml_load_file("$th_pre/information.xml");

							$xml_name=$xml_info -> name;
							$xml_ver=$xml_info -> version;
							$xml_desc=$xml_info -> description;
							$xml_author=$xml_info -> author;
							$xml_email=$xml_info -> email;
							$xml_site=$xml_info -> site;

							$pllst.="<td><b>$xml_name</b><br /></td>
									<td>$xml_desc<br /><br />
									Version: $xml_ver. Author: <a href=\"$xml_site\">$xml_author</a>. Email: $xml_email.<br />";
							if($permission->bpuw == 1){
								if(!$plugin_installed){
									#$pllst.="<a href=\"$th_pre/install.php\">Install</a> - ";
									$pllst.="<a href=\"plugins.php?install=$file\">Install</a> - ";
								}
								else if($plugin_installed && $plugin_active){
									$pllst.="<a href=\"plugins.php?deactivate=$file\">Deactivate</a> - 
									<a href=\"plugins.php?edit=$file\">Edit</a> - ";
								}
								else if($plugin_installed && !$plugin_active){
									$pllst.="<a href=\"plugins.php?activate=$file\">Activate</a> - 
									<a href=\"plugins.php?edit=$file\">Edit</a> - ";
								}

								$pllst.="<a href=\"delete.php?d=$file&t=plugin&h=plugins.php\">Delete</a>";
							}

							$pllst.="</td>";

							
						}
						else{
							$pllst.="Plugin information does not exist.";
						}

						
						
						$pllst.="</tr>";
					}

					$pllst.="</tbody>
					</table>";

					closedir($od);
				}
			}
		}
		else{
			global $plugin;

			$plugin_dir=trim($_GET['edit']);
			$file=trim($_GET['edit']);
			$whole_plugin_dir=$this->td."/".$plugin_dir;

			include($this->td."/".$plugin_dir."/edit.php");		

			$dmp="SELECT * FROM cm_plugins WHERE plugin_dir=\"$file\"";
			if($d=$c->query($dmp))
			{
				if($d->num_rows == 1) $pllst = $plugin->edit_plugin();
				else $pllst.="This plugin is not installed!";
			}

					

			if(file_exists("$whole_plugin_dir/information.xml")){
				$xml_info=simplexml_load_file("$whole_plugin_dir/information.xml");
				$this->plugin_name=$xml_info -> name;
			}
		}

		return $pllst;
	}
	
	

	// Install plugin
	public function InstallPlugin($pluginname)
	{
		global $c;

		if(strlen($pluginname) > 0){

			$plugin_dir=trim($pluginname);

			$dmp="SELECT * FROM cm_plugins WHERE plugin_dir=\"$plugin_dir\"";
			if($d=$c->query($dmp)){
				if($d->num_rows == 0){

					include($this->td."/".$plugin_dir."/install.php"); // Do everything that author want to and dont ask anything
					if(install_plugin() == true){
						$dmp="INSERT INTO cm_plugins(plugin_dir, active) VALUES(\"$plugin_dir\", 0)";
						if($c->query($dmp)){
							#unlink($td."/".$plugin_dir."/install.php"); // This line deletes installation file of just intalled plugin
							exit(header("Location: plugins.php?m=28"));
						}
						else{
							exit(header("Location: plugins.php?m=147"));
						}
					}
					else{
						exit(header("Location: plugins.php?m=148"));
					}
					
				}
				else{
					exit(header("Location: plugins.php?m=148"));
				}
			}
		}
	}

	public function ActivatePlugin($pluginname)
	{
		global $c;

		// Activate plugin
		if(strlen($pluginname) > 0){

			$plugin_dir=trim($pluginname);

			$dmp="UPDATE cm_plugins SET active=1 WHERE plugin_dir=\"$plugin_dir\"";
			if($c->query($dmp)){
				exit(header("Location: plugins.php?m=29"));
			}
			else{
				exit(header("Location: plugins.php?m=149"));
			}
		}
	}

	public function DeactivatePlugin($pluginname)
	{
		global $c;

		// Deactivate plugin
		if(strlen($pluginname) > 0){

			$plugin_dir=trim($pluginname);

			$dmp="UPDATE cm_plugins SET active=0 WHERE plugin_dir=\"$plugin_dir\"";
			if($c->query($dmp)){
				exit(header("Location: plugins.php?m=30"));
			}
			else{
				exit(header("Location: plugins.php?m=150"));
			}
		}
	}

}

# Try to create PluginList object
try
{
	$pluginlist = new PluginList();

	if(isset($_GET['install']))
	{
		$pluginlist->InstallPlugin($_GET['install']);
	}

	if(isset($_GET['activate']))
	{
		$pluginlist->ActivatePlugin($_GET['activate']);
	}

	if(isset($_GET['deactivate']))
	{
		$pluginlist->DeactivatePlugin($_GET['deactivate']);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}




?>