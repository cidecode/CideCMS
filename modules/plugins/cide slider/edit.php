<?php

/*
 * CideSlider plugin V1.0
 * Author: Luka Rogović
 * Website: www.cidecode.com
 */

class CideSlider 
{
	private $plugin_dir;
	private $td;

	public function __construct()
	{
		global $constants;

		$this->plugin_dir = trim($_GET['edit']);
		$this->td=".".$constants::PLUGIN_PATH;
	}

	public function edit_plugin(){
		global $pllst;
		global $cwd;
		global $c;
		global $constants; 		

		$lib_folder = ".".$constants::PLUGIN_PATH."/".$this->plugin_dir."/libary/";

		echo "
				<style>
					form#upload-form input[type=text]{
						border: 1px #d2d2d2 solid;
						outline: none;
						margin: 3px 0px 3px 0px; 
						padding: 5px 5px 5px 5px;
						border-radius: 4px;
					}
					form#upload-form input[type=text]:focus{
						border: 1px #4395cb solid;
					}
					form#upload-form input[type=submit],input[type=button]{
						display: block;
						margin: 0 auto;
						padding: 5px 15px 5px 15px;
						background-color: #4395cb;
						color: #f8f8f8;
						border: 0;
						outline: none;
						border-radius: 3px; 
						font-size: 1em;
					}
					form#upload-form input[type=submit]:hover{
						background-color: #1fafeb;
						cursor: pointer;
					}
					span.infomsg{
						display: block;
						font-size: 0.9em;
						font-weight: normal;
						text-align: center;
					}
					span.code{
						border: 1px #6F6F6F solid;
						background-color: #E0E0E0;
						padding: 10px;
						font-size: 0.9em;
						font-style: italic;
					}
				</style>
		";

		if(isset($_GET['csm'])) $csm=$_GET['csm'];
		else $csm=0;

		echo "
				<script type=\"text/javascript\">

				$(document).ready(function(){
					

					switch($csm){
						case 1: csmi=\"Format of file is not supported!\"; break;
						case 2: csmi=\"The image was uploaded successfuly!\"; break;
						case 3: csmi=\"Could not upload image!\"; break;
						case 4: csmi=\"The file has been deleted!\"; break;
						case 5: csmi=\"The file could not be deleted!\"; break;
						case 6: csmi=\"The slide has been activated!\"; break;
						case 7: csmi=\"The slide could not be activated!\"; break;
						case 8: csmi=\"The slide has been deactivated!\"; break;
						case 9: csmi=\"The slide could not be deactivated!\"; break;
						case 10: csmi=\"The slide order has been updated!\"; break;
						case 11: csmi=\"The slide order could not be updated!\"; break;
						default: csmi=\"\"; break;
					}

					$('#cideslider-msg').show().text(csmi);


				});

				
				

				</script>
		";

		$pllst.="<form action=\"$constants->cwd?edit=$this->plugin_dir\" method=\"post\" id=\"upload-form\" enctype=\"multipart/form-data\">
					<table class=\"user-list\">
						<tbody>
							<tr>
								<td>Upload from computer </td>
								<td>
									<input type=\"file\" name=\"file_upload\" /><br />
									<span class=\"info\">(Click the above button to select file you wish to upload. Only PNG and JPEG.)</span>
								</td>
							</tr>
							<tr>
								<td>Upload from link</td>
								<td>
									<input type=\"text\" name=\"file_link\" /><br />
									<span class=\"info\">(You can leave it blank and change it later or change it now.)</span>
								</td>
							</tr>
							<tr>
								<td colspan=\"2\">
									<input type=\"submit\" name=\"upload_file_btn\" value=\"Upload\" /><br />
								</td>
							</tr>
							<tr>
								<td colspan=\"2\">
									<span class=\"infomsg\" id=\"cideslider-msg\">teeest</span>
								</td>
							</tr>
						</tbody>
					</table>
				</form>";

		$dmp="SELECT COUNT(*) FROM cm_cideslider";
		if($d=$c->query($dmp)){ 
			while($v=$d->fetch_row()):
				$this->pca=$v[0];
			endwhile;
		}

		if($this->pca != 0){

			$dmp="SELECT cs_id as ci,link as ln,active as ac,slide_order as so 
				  FROM cm_cideslider
				  ORDER BY slide_order ASC";

			$d=$c->query($dmp); 
			
		$pllst.="<br /><h3>Slide list</h3><br />";

		$pllst.= "<table class=\"table-list\">
										<thead>
											<th>Preview</th>
											<th>Link</th>
											<th>Active</th>
											<th>Order</th>
											<th>Action</th>
										</thead>
										<tbody>";

										while($v=$d->fetch_assoc()){
											
		$pllst.="									
											<tr class=\"plrow\">
												<td class=\"media-width\">
													<a href=\"".$v['ln']."\"><img src=\"".$v['ln']."\" class=\"media-small\" /></a>
												</td>
												<td>".$v['ln']."</td>
												<td>
				";
													
														if($v['ac'] == 1) $pllst.= "<a href=\"$cwd?edit=$this->plugin_dir&action=deactivate&link=".$v['ln']."\"><img src=\"".$lib_folder."yes.png\" alt=\"Deactivate\" /></a>";
														else $pllst.="<a href=\"$cwd?edit=$this->plugin_dir&action=activate&link=".$v['ln']."\"><img src=\"".$lib_folder."no.png\" alt=\"Activate\" /></a>";
													
		$pllst.="										</td>
												<td>".$v['so']." - <a href=\"$cwd?edit=$this->plugin_dir&action=up&link=".$v['ln']."\"><img src=\"".$lib_folder."plus.png\" alt=\"Up\" /></a>  <a href=\"$cwd?edit=$this->plugin_dir&action=down&link=".$v['ln']."\"><img src=\"".$lib_folder."minus.png\" alt=\"Down\" /></a></td>
												<td><a href=\"$cwd?edit=$this->plugin_dir&action=delete&link=".$v['ln']."\"><img src=\"".$lib_folder."trash.png\" /></a></td>
											</tr>";
										}
		$pllst.="						</tbody>
									</table>"; 
		} 

		$insert_code = "&#60;?php include(\"modules/plugins/".$this->plugin_dir."/slider.php\"); ?&#62;";

		$pllst.="<br /><br /><h3>Usage</h3><br />
				<p>To use this plugin on your site insert bellow code where you want on your site:</p>
				<span class=\"code\">$insert_code</span>
		";

		return $pllst;
	}

	public function cideslider_upload(){ 
		global $c;
		global $options;


		$whole_plugin_dir=$this->td."/".$this->plugin_dir."/images";

		$mime_supported_types=array( 
								"image/png" => "png",
								"image/jpeg" => "jpeg"
								); 


		// Number of supported mime types
		$mime_type_num=count($mime_supported_types);

		// Checking and uploading
		if(isset($_FILES['file_upload']) && !empty($_FILES['file_upload']['name']) && strlen($_POST['file_link']) <= 0){

			// Uploaded file type
			$upl_type=$_FILES['file_upload']['type'];

			foreach ($mime_supported_types as $indx => $vale) {
				if($upl_type == $indx){
					$type_exists=1;
					$upl_ext=$vale;
					$type_sort=explode("/",$indx)[0];
					break;
				}
			} 
			
			// Upload file name
			$upl_name=$_FILES['file_upload']['name'];


			// Stop script if file type is not allowed
			if(!isset($type_exists) || $type_exists != 1){
				exit(header("Location: ".host_uri()."&csm=1"));
				echo "Format of file is not supported!1";
			}

			// Find max file size on choosen file type
			if(isset($type_exists) && $type_exists == 1){
				$max_file_size=2048*1024;
			}

			if(isset($max_file_size) && $_FILES['file_upload']['size'] <= $max_file_size){
				$min=1111; $max=mt_getrandmax();
				$next_upl=mt_rand($min,$max);

				$upl_link=$options->site_host()."/modules/plugins/".$this->plugin_dir."/images/".$next_upl.".".$upl_ext;
				
				$upl_size=$_FILES['file_upload']['size'];
				$upl_tmp=$_FILES['file_upload']['tmp_name'];

				$shr_type=explode("/",$upl_type)[1];
				$dir_name="images";

				# Upload file
				if(file_exists($whole_plugin_dir."/$next_upl.$upl_ext")){
					while(1){
						$next_upl=mt_rand($min,$max);
						if(!file_exists($whole_plugin_dir."/$next_upl.$upl_ext")){
							break;
						}
					}
				}
				else{
					move_uploaded_file($upl_tmp, $whole_plugin_dir."/$next_upl.$upl_ext");
					$new_img=$options->site_host()."/$whole_plugin_dir/$next_upl.$upl_ext";
										
					$upl_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

					$dmp="INSERT INTO cm_cideslider(link,active,slide_order)
							VALUES(
								\"$upl_link\",
								1,
								0)";
							
					if($c->query($dmp)){
						$upl_res=$new_img;
						$upl_last_id=$c->insert_id;
						exit(header("Location: $constancwd?edit=$this->plugin_dir&csm=2"));
					}
					else{
						$upl_res=NULL;
						exit(header("Location: $cwd?edit=$this->plugin_dir&csm=3"));
					}
				}
			}
		}
		else if(empty($_FILES['upload']['name']) && isset($_POST['file_link']) && strlen($_POST['file_link']) > 0){
			$file_link=trim($_POST['file_link']);

			$dmp="INSERT INTO cm_cideslider(link,active,slide_order)
							VALUES(
								\"$file_link\",
								1,
								0)";
							
					if($c->query($dmp)){
						$upl_last_id=$c->insert_id;
						exit(header("Location: $cwd?edit=$this->plugin_dir&csm=2"));
					}
					else{
						$upl_res=NULL;
						exit(header("Location: $cwd?edit=$this->plugin_dir&csm=3"));
					}
		}
		else{
			exit(header("Location: $cwd?edit=$this->plugin_dir&csm=3"));
			$upl_res=NULL;
		}
		
	}

	

	public function delete_slide($link){
		global $c;
		global $cwd;

		$pw=explode('/',$link);
		$file_path='';
		for($i=6; $i<count($pw); $i++){
			if($i==count($pw)-1){
				$file_path.=$pw[$i];
			}
			else{
				$file_path.=$pw[$i].'/';
			}
		} 
		$true_file_path = "../".PLUGIN_PATH."/$file_path";

		$dmp="DELETE FROM cm_cideslider WHERE link=\"$link\"";
		if($c->query($dmp)){
			if(file_exists($true_file_path)){
				unlink($true_file_path);
			}
			exit(header("Location: $cwd?edit=$this->plugin_dir&csm=4"));
		}
		else{
			exit(header("Location: $cwd?edit=$this->plugin_dir&csm=5"));
		}
	}

	public function activate_slide($link){
		global $c;
		global $cwd;

		$dmp="UPDATE cm_cideslider SET active=1 WHERE link=\"$link\"";
		if($c->query($dmp)){
			exit(header("Location: $cwd?edit=$this->plugin_dir&csm=6"));
		}
		else{
			exit(header("Location: $cwd?edit=$this->plugin_dir&csm=7"));
		}
	}

	public function deactivate_slide($link){
		global $c;
		global $cwd;

		$dmp="UPDATE cm_cideslider SET active=0 WHERE link=\"$link\"";
		if($c->query($dmp)){
			exit(header("Location: $cwd?edit=$this->plugin_dir&csm=8"));
		}
		else{
			exit(header("Location: $cwd?edit=$this->plugin_dir&csm=9"));
		}
	}

	public function up_slide($link){
		global $c;
		global $cwd;

		$dmp="SELECT slide_order FROM cm_cideslider WHERE link=\"$link\"";
		$d=$c->query($dmp);
		$v=$d->fetch_assoc();

		$num = (int)$v['slide_order'];

		$num ++;

		$dmp="UPDATE cm_cideslider SET slide_order=$num WHERE link=\"$link\"";
		if($c->query($dmp)){
			exit(header("Location: $cwd?edit=$this->plugin_dir&csm=10"));
		}
		else{
			exit(header("Location: $cwd?edit=$this->plugin_dir&csm=11"));
		}
	}

	public function down_slide($link){
		global $c;
		global $cwd;

		$dmp="SELECT slide_order FROM cm_cideslider WHERE link=\"$link\"";
		$d=$c->query($dmp);
		$v=$d->fetch_assoc();

		$num = (int)$v['slide_order'];

		$num --;

		if($num < 0) $num = 0;

		$dmp="UPDATE cm_cideslider SET slide_order=$num WHERE link=\"$link\"";
		if($c->query($dmp)){
			exit(header("Location: $cwd?edit=$this->plugin_dir&csm=10"));
		}
		else{
			exit(header("Location: $cwd?edit=$this->plugin_dir&csm=11"));
		}
	}

}

# Creating CideSlider object
try
{
	$plugin = new CideSlider();

	if(isset($_POST['upload_file_btn']))
	{
		$plugin->cideslider_upload();
	}

	if(isset($_GET["action"]) && $_GET["action"] == "delete")
	{
		$plugin->delete_slide($_GET["link"]);
	}
	else if(isset($_GET["action"]) && $_GET["action"] == "activate")
	{
		$plugin->activate_slide($_GET["link"]);
	}
	else if(isset($_GET["action"]) && $_GET["action"] == "deactivate")
	{
		$plugin->deactivate_slide($_GET["link"]);
	}
	else if(isset($_GET["action"]) && $_GET["action"] == "up")
	{
		$plugin->up_slide($_GET["link"]);
	}
	else if(isset($_GET["action"]) && $_GET["action"] == "down")
	{
		$plugin->down_slide($_GET["link"]);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>