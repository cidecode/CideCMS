<?php 
									
/*
 * This is class for editing media
 */	

class EditMedia
{
	public $id;
	public $nm;
	public $dc;
	public $ln;
	public $mt;
	public $ms;
	public $ud;


	public function __construct()
	{
		$this->CheckPerm();

		if(isset($_GET['f']))
		{
			$this->ViewMedia();
		}
		else
		{
			exit(header("Location: index.php"));
		}
	} 

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->bpsr,$permission->bpsw,'editmedia','&f='.$_GET['f']);
	}

	# GRAB THE USER ID FOR EDITING
	private function ViewMedia()
	{
		global $c;

		$this->id=$_GET['f'];

		$dmp="SELECT name as nm,description as dc,link as ln,media_type as mt,media_size as ms,upload_date as ud,active as ac 
			  FROM cm_media
			  WHERE me_id=$this->id";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_assoc()){
				$this->nm=$v['nm'];
				$this->dc=$v['dc'];
				$this->ln=$v['ln'];
				$this->mt=$v['mt'];
				$this->ms=round(($v['ms']/1024)/1024,2);
				$this->ud=date("d.m.Y",$v['ud'])." at ".date("H:m:s",$v['ud']);
				$ac=$v['ac'];												

				if($ac == 1) $this->mfa="<input type=\"checkbox\" name=\"file_active\" checked />Activate the file<br />";
				else $this->mfa="<input type=\"checkbox\" name=\"file_active\" />Activate the file<br />";

			}
		}
		else{
			return "<can not grab the file>";
		}

	} 
	# EDITING THE USER
	public function Edit()
	{
		global $c;
		global $options;
		global $tracking;
		
		# File name
		$file_name=$_POST['file_name'];
		# File description
		$file_desc=$_POST['file_desc'];
		# File activation
		if(isset($_POST['file_active'])) $file_active=1; else $file_active=0;	

		# SQL dumping = cm_media 
		
		$dmp="UPDATE cm_media
			  SET
				name=\"$file_name\",
				description=\"$file_desc\",
				active=$file_active
			  WHERE me_id=$this->id";
		
		
		if($c->query($dmp)){
			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('media',$file_name,'UPDATE');
			}

			# Redirection to editmedia.php
			exit(header("Location: editmedia.php?f=$this->id&m=12"));
								
		}
		else{
			# Redirection to editmedia.php
			exit(header("Location: editmedia.php?f=$this->id&m=117"));
		}

	}
}

# Try to create EditMedia object
try
{
	$editmedia = new EditMedia();

	if(isset($_POST['edit_file_btn']))
	{
		$editmedia->Edit();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>