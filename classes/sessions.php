<?php

/*
 * This is class for creating user sessions.
 */

class Sessions
{
	public $s_user_id;
	public $s_username;

	public $s_ut_id;
	public $s_status_name;

	public $f_ses;
	public $s_ses;

	public $user_info;

	public function CreateSession($userid, $username, $statusid, $statusname, $userperm)
	{
		$_SESSION['id_username'] = $userid.":".$username;
		$_SESSION['id_status'] = $statusid.":".$statusname;
		$_SESSION['user_perm'] = $userperm;
	}

	public function CheckSession($name)
	{
		switch($name)
		{
			case "id_username": 
				if(isset($_SESSION[$name]))
				{
					$iu_sesion = $_SESSION[$name];
					$this->s_user_id = explode(":",$iu_sesion)[0]; 
					$this->s_username = explode(":",$iu_sesion)[1];
					$this->f_ses = true;
				}
				else
				{
					$this->f_ses = false;
				}
				break;
			case "id_status": 
				if(isset($_SESSION[$name]))
				{
					$iu_sesion = $_SESSION[$name];
					$this->s_ut_id = explode(":",$iu_sesion)[0]; 
					$this->s_status_name = explode(":",$iu_sesion)[1];
					$this->s_ses = true;
				}
				else
				{
					$this->s_ses = false;
				}
				break;
			default: break;
		}

	}

	public function WriteUserInfo()
	{
		global $host_uri;

		if($this->f_ses || $this->s_ses){
			$this->user_info="<span>Welcome <span class=\"l-i\">".$this->s_username."</span> (<a href=\"login.php?hu=".$host_uri->host_uri()."&action=logout\">log out</a>)</span>";
		}
		else{
			$this->user_info="<span>Welcome <span class=\"l-i\">Guest</span> (<a href=\"login.php?hu=".$host_uri->host_uri()."\">log in</a>)</span>";
		}
	}

	
}

# Try to determine if the session exists or not
try
{
	$sessions = new Sessions();

	# Check sessions
	$sessions->CheckSession("id_username");
	$sessions->CheckSession("id_status");

	# Write user info message
	$sessions->WriteUserInfo();
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>