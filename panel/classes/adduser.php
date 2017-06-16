<?php 

/*
 * This is a class for adding new user
 */

class AddUser extends Upload
{
	public $gur;

	public function __construct()
	{
		$this->CheckPerm();
		$this->gur = $this->GrabUserRole();
	}

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->busr,$permission->busw,'users','');
	}

	# EDITING THE USER
	public function NewUser()
	{
		global $c;
		global $ss1;
		global $options;
		global $tracking;

		# User name
		$user_name=trim($_POST['user_name']);
			// Searching if the username already exists
			$dmp="SELECT us_id FROM cm_users WHERE username=\"$user_name\"";
			if($d=$c->query($dmp)){
				$pd0=$d->num_rows;
				if($pd0 == 1)
					exit(header("Location: adduser.php?m=113"));
			}
		# User password
		if(trim($_POST['user_passwd1']) == trim($_POST['user_passwd2']) && strlen($_POST['user_passwd1']) >= 6) 
			$user_passwd=$ss1->shiftshell(trim($_POST['user_passwd1']));
		# User email
		$user_email=trim($_POST['user_email']);
			// Searching if the user email already exists
			$dmp="SELECT us_id FROM cm_users WHERE user_email=\"$user_email\"";
			if($d=$c->query($dmp)){
				$pd0=$d->num_rows;
				if($pd0 == 1)
				{ 
					exit(header("Location: adduser.php?m=114"));
				}
			}
		# Full name
		$full_name=$_POST['full_name'];
		# Birth date
		if(isset($_POST['birth_date']) && strlen($_POST['birth_date']) > 0){
			$bd_ary=explode(".",$_POST['birth_date']);
			$bd=$bd_ary[0]; echo $bd;
			$bm=$bd_ary[1]; echo $bm;
			$by=$bd_ary[2]; echo $by;
			$birth_date=mktime(23,59,59,$bm,$bd,$by);

			$birth_exists=true;
		}
		else{
			$birth_exists=false;
		}
		# Join
		$join_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
		# User role
		$user_role=$_POST['user_role'];
		# User activation
		if(isset($_POST['user_active'])) $user_active=1; else $user_active=0;	

		# Uploading avatar
		$this->AddFile();
		$this->GetUploadResult();

		# SQL dumping = cm_users 
		if(!$birth_exists){
			$dmp="INSERT INTO cm_users(username,passwd,nickname,user_email,full_name,join_date,active,type,avatar)
				VALUES(
					\"$user_name\",
					\"$user_passwd\",
					\"$user_name\",
					\"$user_email\",
					\"$full_name\",
					$join_date,
					$user_active,
					$user_role,";
			if($this->GetUploadResult() == NULL) $dmp.="NULL);";
			else $dmp.="\"".$this->GetUploadResult()."\");";
			
		}
		else{
			$dmp="INSERT INTO cm_users(username,passwd,nickname,user_email,full_name,birth_date,join_date,active,type,avatar)
				VALUES(
					\"$user_name\",
					\"$user_passwd\",
					\"$user_name\",
					\"$user_email\",
					\"$full_name\",
					$birth_date,
					$join_date,
					$user_active,
					$user_role,";
			if($this->GetUploadResult() == NULL) $dmp.="NULL);";
			else $dmp.="\"".$this->GetUploadResult()."\");";
		}
		 
		
		if($c->query($dmp)){ 
			$id=$c->insert_id;
			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('user',$user_name,'INSERT');
			}

			# Setting avatar to NULL if is not set
			if($this->GetUploadResult() != NULL){				
				$dmp="UPDATE cm_media SET description=\"avatar\" WHERE link=\"$this->upl_res\"";
				if($c->query($dmp))
				{
					exit(header("Location: edituser.php?u=$id&m=11"));
				}
				else
				{
					exit(header("Location: edituser.php?u=$id&m=154"));
				}
			}
			else
			{
				exit(header("Location: edituser.php?u=$id&m=11"));
			}
		}
		else{			
			exit(header("Location: adduser.php?m=114"));
		}

	}

	# GRAB USER ROLE
	private function GrabUserRole(){	
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

# Try to create AddUser object
try
{
	$adduser = new AddUser();

	if(isset($_POST['add_user_btn']))
	{
		$adduser->NewUser();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>