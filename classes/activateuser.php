c<?php 

/*
 * This class is for activating new users
 */

class ActivateUser
{
# Confirm user reset password
# Check users permisions

	
	public function __construct($ackey)
	{
		if(strlen($ackey) > 0 && $ackey != '')
		{
			global $c;

			$timenow=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

			// SQL dumping - check if user exists and if data matches
			$dmp="SELECT ua_id as uai, user_id as ui, creationdate as cd FROM cm_useractivation WHERE activationkey=\"$ackey\""; 
			if($d=$c->query($dmp)){
				
					if($d->num_rows != 1){
						exit(header("Location: activateuser.php?m=145"));
					}
					else{
						$r=$d->fetch_assoc();
						$uai=$r['uai'];
						$ui=$r['ui'];
						$cd=(int)$r['cd'];

						if($cd+604800 <= (int)$timenow)
						{
							exit(header("Location: activateuser.php?m=145"));
						}
						else{
							$dmp="UPDATE cm_users SET active=1 WHERE us_id=$ui";
							if($c->query($dmp)){
								$dmp="DELETE FROM cm_useractivation WHERE ua_id=$uai";
								if($c->query($dmp)){
									$reg_msg="The sucessfuly activated your account, please <a href=\"login.php\">log in</a>";
									echo "
										<script type=\"text/javascript\">
											window.onload=function(){ document.getElementById('message-s').innerHTML='$reg_msg'; }
										</script>
									";
									exit(header("Location: activateuser.php?m=27"));
								}
							}
						}
					}
				 
			} 
		}
	}
}

# Try to create ActivateUser object
try
{ 
	if(isset($_GET['ackey']))
	{
		if(isset($_SESSION['id_username']) || strlen($_GET['ackey']) == 0)
		{
			exit(header("Location: ".$options->site_host()));
		}
		else
		{
			$activateuser = new ActivateUser($_GET['ackey']);
		}
	}
	elseif(!isset($_GET['ackey']) && !isset($_GET['m']))
	{
		exit(header("Location: ".$options->site_host()));
	}
		
}
catch(Exception $e)
{
	die($e->getMessage());
}


?>