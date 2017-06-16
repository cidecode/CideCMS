<?php 

/*
 * This is a class for adding new media file
 */									

class AddMedia extends Upload
{
	public function __construct()
	{
		$this->CheckPerm();
	}

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->bmdr,$permission->bmdw,'media','');
	}

	

	# EDITING THE USER
	public function NewMedia()
	{
		global $c;
		global $options;
		global $tracking;
		
		# Uploading media file
		$this->AddFile();

		# File name
		$file_name=$_POST['file_name'];
		# File description
		$file_desc=$_POST['file_desc'];
		# File activation
		if(isset($_POST['file_active'])) $file_active=1; else $file_active=0;

		// If media file name and description is set update media file
		# SQL dumping = cm_media 
		if(strlen($file_name) > 0 && strlen($file_desc) > 0){
			$dmp="UPDATE cm_media
			      SET name=\"$file_name\",description=\"$file_desc\",active=$file_active
			      WHERE me_id=$this->upl_last_id";
		}
		else if(strlen($file_name) > 0 && strlen($file_desc) == 0){
			$dmp="UPDATE cm_media
			      SET name=\"$file_name\",active=$file_active
			      WHERE me_id=$this->upl_last_id";
		}
		else if(strlen($file_name) == 0 && strlen($file_desc) > 0){
			$dmp="UPDATE cm_media
			      SET description=\"$file_desc\",active=$file_active
			      WHERE me_id=$this->upl_last_id";
		}
		else{
			$dmp="UPDATE cm_media
			      SET active=$file_active
			      WHERE me_id=$this->upl_last_id";
		}
		
		
		
		if($c->query($dmp)){
			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('media',$upl_name,'INSERT');
			}
			# Redirection to editmedia.php
			exit(header("Location: editmedia.php?f=$this->upl_last_id&m=13"));
								
		}
		else{
			# Redirection to addmedia.php
			exit(header("Location: addmedia.php?m=118"));
		}

	}
}

# Try to create AddMedia object
try
{
	$addmedia = new AddMedia();

	if(isset($_POST['upload_file_btn']))
	{
		$addmedia->NewMedia();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>