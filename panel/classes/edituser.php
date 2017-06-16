<?php 

/*
 * This is a class for editing user
 */									

class EditUser extends Upload
{
	public $id;
	public $un;
	public $ue;
	public $tp;
	public $fn;
	public $ar;
	public $us;
	public $sn;
	public $sd;
	public $nk;
	public $jd;
	public $bd;
	public $uaa;
	public $gdn;
	public $gur;

	public function __construct()
	{
		$this->CheckPerm();

		if(isset($_GET['u']))
		{
			$this->ViewUser();
		}
		else
		{
			exit(header("Location: index.php"));
		}

		$this->gdn = $this->GrabDisplayName($this->id);
		$this->gur = $this->GrabUserRole();
	} 

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->busr,$permission->busw,'edituser','&u='.$_GET['u']);
	}


	# GRAB THE USER ID FOR EDITING
	private function ViewUser()
	{
		global $c;

		$this->id=$_GET['u'];

		$dmp="SELECT username as un,user_email as ue,nickname as nk,
			  join_date as jd,active as ac, type as tp,
			  CASE WHEN full_name IS NOT NULL THEN full_name ELSE '' END as fn,
			  CASE WHEN avatar IS NOT NULL THEN avatar ELSE 'none' END as ar,
			  CASE WHEN birth_date IS NOT NULL THEN birth_date ELSE 'DD.MM.YYYY' END as bd,
			  ut_id as us,status_name as sn,status_desc as sd
			  FROM cm_users u INNER JOIN cm_userstatus s ON u.type=s.ut_id
			  WHERE us_id=$this->id";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_assoc()){
				$this->un=$v['un'];
				$this->ue=$v['ue'];
				$this->tp=$v['tp'];
				$this->fn=$v['fn'];
				$this->ar=$v['ar'];
				$this->us=$v['us'];
				$this->sn=$v['sn'];
				$this->sd=$v['sd'];
				$this->nk=$v['nk'];
				$ac=$v['ac'];

				if($v['jd'] != 'none') 
					$this->jd=date("d.m.Y",$v['jd']); 
				else 
					$this->jd=$v['jd'];


				if($v['bd'] != 'DD.MM.YYYY') 
					$this->bd=date("d.m.Y",$v['bd']); 
				else 
					$this->bd=$v['bd'];
												

				if($ac == 1) $this->uaa="<input type=\"checkbox\" name=\"user_active\" checked />Activate the user<br />";
				else $this->uaa="<input type=\"checkbox\" name=\"user_active\" />Activate the user<br />";

			}
		}
		else{
			return "<can not grab the user>";
		}

	} 

	# EDITING THE USER
	public function Edit()
	{
		global $c;
		global $options;
		global $ss1;
		global $tracking;
		
		# User password
		if(strlen(trim($_POST['user_passwd'])) > 0) $user_passwd=$ss1->shiftshell(trim($_POST['user_passwd']));
		# User email
		$user_email=$_POST['user_email'];
		# Full name
		$full_name=$_POST['full_name'];
		# Display name
		$display_name=$_POST['display_name'];
		# Birth date
		if($_POST['birth_date'] != 'DD.MM.YYYY'){
			$bd_ary=explode(".",$_POST['birth_date']);
			$bd=$bd_ary[0]; echo $bd;
			$bm=$bd_ary[1]; echo $bm;
			$by=$bd_ary[2]; echo $by;
			$birth_date=mktime(23,59,59,$bm,$bd,$by);
		}
		else{
			$birth_date='NULL';
		}
		# User role
		if($this->id == 1) $user_role=1; else $user_role=$_POST['user_role'];
		# User activation
		if(isset($_POST['user_active'])) $user_active=1; else $user_active=0;	

		# Uploading avatar
		if(isset($_FILES['upload']) && !empty($_FILES['upload']['name']))
		{
			$this->AddFile();
		}

		# SQL dumping = cm_post 
		if(isset($user_passwd)){
			$dmp="UPDATE cm_users
			SET
				passwd=\"$user_passwd\",
				user_email=\"$user_email\",
				full_name=\"$full_name\",
				nickname=\"$display_name\",
				birth_date=$birth_date,
				active=$user_active,
				type=$user_role
			WHERE us_id=$this->id";
		}
		else{
			$dmp="UPDATE cm_users
			SET
				user_email=\"$user_email\",
				full_name=\"$full_name\",
				nickname=\"$display_name\",
				birth_date=$birth_date,
				active=$user_active,
				type=$user_role
			WHERE us_id=$this->id";
		} 
		
		if($c->query($dmp)){
			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('user',$un,'UPDATE');
			}

			# Setting avatar to NULL if is not set
			if($this->upl_res != NULL){
				$dmp="UPDATE cm_users SET avatar=\"$this->upl_res\" WHERE us_id=$this->id"; 
				$c->query($dmp);

				# Setting description on file in cm_media table
				if(isset($this->upl_last_id)){
					$dmp="UPDATE cm_media SET description=\"avatar\" WHERE link=\"$this->upl_res\""; 
					$c->query($dmp);
				}
			}

			exit(header("Location: edituser.php?u=$this->id&m=9"));
								
		}
		else{
			# Redirection to editpost.php
			exit(header("Location: edituser.php?u=$this->id&m=111"));
		}

	}



	# REMOVING AVATAR
	public function RemoveAvatar()
	{
		global $c;
		global $constants;

		if(isset($_GET['rm']) && $_GET['rm'] == 'avatar' && isset($_GET['u']) && isset($_GET['av']))
		{
			$av=$_GET['av'];
			# Setting avatar to NULL if is not set
			$dmp="UPDATE cm_users SET avatar=NULL WHERE us_id=$this->id"; 
			if($c->query($dmp)){
				$dmp="DELETE FROM cm_media WHERE link=\"$av\""; 
				if($c->query($dmp)){
					$av_ary=explode("/",$av);
					$av_select=count($av_ary)-1;
					$av=$av_ary[$av_select];
					$del_file=$constants::MEDIA_PATH."/$av"; 

					// Deleting file from server
					@unlink($del_file); 

					if(!file_exists($del_file)){				
						exit(header("Location: edituser.php?u=$this->id&m=10"));
					}
					else{
						exit(header("Location: edituser.php?u=$this->id&m=113"));	
					}
				}
				
			}
			else
				exit(header("Location: edituser.php?u=$this->id&m=112"));				
		}
	}


	# GRAB DISPLAY NAME
	private function GrabDisplayName($id){	
		global $c;

		$dmp="SELECT username,full_name,nickname 
			  FROM cm_users 
			  WHERE us_id=$this->id";
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
		
	}

	# GRAB USER ROLE
	function GrabUserRole(){	
		global $c;

		$dmp="SELECT ut_id,status_name as usn,status_desc as usd
			  FROM cm_userstatus";
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}
}

# Try to create EditUser object
try
{
	$edituser = new EditUser();

	if(isset($_POST['edit_user_btn']))
	{
		$edituser->Edit();
	}

	if(isset($_GET['rm']))
	{
		$edituser->RemoveAvatar();
	}


}
catch(Exception $e)
{
	die($e->getMessage());
}

?>