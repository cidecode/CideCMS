<?php 

/*
 * This is a class that will check the user
 * information and create session.
 */

class Login
{
	public $host_pg;

	public function __construct()
	{
		global $options;

		// Page from which user came
		if(isset($_GET['hu'])){
			$this->host_pg=$_GET['hu'];
		}
		else{
			$this->host_pg=$options->site_host();
		}
	}

	public function Login()
	{
		global $c;
		global $ss1;
		global $host_uri;
		global $sessions;
		global $permission;
		global $options;

		if(strlen($_POST['ur_nm']) >= 1 && strlen($_POST['ur_ps']) > 1){
			$username=trim($_POST['ur_nm']);
			$passwd=trim($ss1->shiftshell($_POST['ur_ps']));

			// SQL dumping - check if user exists and if data matches
			$dmp="SELECT username FROM cm_users WHERE username=\"$username\""; 
			if($d=$c->query($dmp)){
				if($d->num_rows != 1){
					exit(header("Location: ".$host_uri->host_uri()."&m=126"));
				}

				// SQL dumping - check data
				$dmp="SELECT us_id as ui,username as un,ut_id as ti,status_name as sn,user_perm as up, active as ac 
				FROM cm_users u INNER JOIN cm_userstatus s ON u.type=s.ut_id 
				WHERE username=\"$username\" AND passwd=\"$passwd\""; 

				if($d=$c->query($dmp)){
					if($d->num_rows != 1){ 
						exit(header("Location: ".$host_uri->host_uri()."&m=127"));
					}
					else{
						
						$r=$d->fetch_assoc();
						if($r['ac'] != 1){ 
							exit(header("Location: ".$host_uri->host_uri()."&m=137"));
						}

						$sessions->CreateSession($r['ui'],$r['un'],$r['ti'],$r['sn'],$r['up']);

						// Redirect to previous page
						$permission->BuildSession($r['up']);
						if($permission->bcpr == 1)
						{
							exit(header("Location: ".$options->site_host()."/panel"));
						}
						else
						{
							exit(header("Location: $this->host_pg"));
						}
						
					}
				}
			}
		}
	}

	public function Logout()
	{
		session_destroy();
		exit(header("Location: $this->host_pg"));		
	}
}

# Try to create Login object
try
{
	$login = new Login();

	
	# Do the action
	if(isset($_POST['login']))
	{
		$login->Login();
	}
	elseif(isset($_GET['action']) && ($_GET['action'] == "logout"))
	{
		$login->Logout();
	}
	# Check if user is already loged in
	elseif(isset($_SESSION['id_username'])){
		exit(header("Location: ".$options->site_host()));
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}



?>