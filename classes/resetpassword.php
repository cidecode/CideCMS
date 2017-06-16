<?php 

/*
 * This is a class for reseting user password
 */

class ResetPassword
{

# Confirm user reset password
# Check users permisions

	public $resetkey;
	private $ri;
	private $ui;

	public function CheckResetKey($resetkey)
	{
		$this->resetkey = $resetkey;

		if(strlen($this->resetkey) > 0 && $this->resetkey != '')
		{
			global $c;

			$timenow=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

			// SQL dumping - check if user exists and if data matches
			$dmp="SELECT rp_id as ri, user_id as ui, createdate as cd FROM cm_forgetpasswd WHERE forgetkey=\"$this->resetkey\""; 
			
			if($d=$c->query($dmp)){
				if($d->num_rows != 1){
					exit(header("Location: resetpassword.php?m=140")); # key does not exists
				}
				else{
					$r=$d->fetch_assoc();
					$this->ri=$r['ri'];
					$this->ui=$r['ui'];
					$cd=(int)$r['cd'];

					if($cd+86400 <= (int)$timenow)
					{
						exit(header("Location: resetpassword.php?m=140")); # key has expiered
					}
				}
			}
			
		}
		else{
			exit(header("Location: resetpassword.php?m=140"));
		}
	}

	// Grab user data and execute stuff
	public function CreateNewPassword($new_psw,$con_psw)
	{
		if(strlen($this->resetkey) > 0 && $new_psw != '' && $con_psw != ''){ 

			global $c;
			global $ss1;

			$new_password = trim($ss1->shiftshell($new_psw)); 
			$confirm_password = trim($ss1->shiftshell($con_psw)); 

			if($new_password == $confirm_password){ 
				$dmp="UPDATE cm_users
					SET
						passwd=\"$new_password\"
					WHERE us_id=$this->ui";

				if($c->query($dmp)){
					$dmp="DELETE FROM cm_forgetpasswd WHERE rp_id=$this->ri";
					if($c->query($dmp)){
						exit(header("Location: resetpassword.php?m=25")); # succesfull change
					}
					else{
						echo $dmp;
					}
				}
				else{
					echo $dmp;
				}	
			}
			else{
				exit(header("Location: resetpassword.php?key=$resetkey&m=141")); #passwords are not same
			}

		}
	}

}

# Try to create ResetPassword object
try
{ 
	if(isset($_GET['key']))
	{
		if(isset($_SESSION['id_username']) || strlen($_GET['key']) == 0)
		{
			exit(header("Location: ".$options->site_host()));
		}
		else
		{
			$resetpassword = new ResetPassword();

			$resetpassword->CheckResetKey($_GET['key']);

			if(isset($_POST['reset_btn']))
			{
				$resetpassword->CreateNewPassword($_POST['new_psw'],$_POST['con_psw']);
			}
		}
	}
	elseif(!isset($_GET['key']) && !isset($_GET['m']))
	{
		exit(header("Location: ".$options->site_host()));
	}
		
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>