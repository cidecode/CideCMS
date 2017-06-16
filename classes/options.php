<?php 

/*
 * This is class that contains all values
 * about site that are important.
 */

class Options
{ 
	# Site name
	public function site_name(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"site_name\"";
		if($d=$c->query($dmp)){ 
			while($r=$d->fetch_assoc()){
				$sn=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sn="<can't grab site name>";
		}
		return $sn; 
	}

	# Site description
	public function site_desc(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"site_description\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sd=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sd="<can't grab site description>";
		}
		return $sd;
	}

	# Site name and description togther
	public function site_title(){
		$st=$this->site_name()." - ".$this->site_desc();
		echo $st;
		return;
	}

	# Site admin
	# Call site_admin() and pass it an option: 'index' or 'name'
	public function site_admin($z){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"site_admin\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sai=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
			$dmp="SELECT username FROM cm_users WHERE us_id=$sa";
			if($d=$c->query($dmp)){
				while($r=$d->fetch_array(MYSQLI_ASSOC)){
					$san=$r['username'];
					mysqli_free_result($d);
					break;
				}
			}
		}
		else{
			$sd="<can't grab site description>";
		}
		
		if($z == 'index') return $sai;
		else if($z == 'name') return $san;
		else return false;
	}

	# Site description
	public function site_email(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"site_email\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$se=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$se="<can't grab site email>";
		}
		return $se;
	}

	# Site description
	public function site_host(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"site_host\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sh=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sh="<can't grab site host>";
		}
		return $sh;
	}

	# Site comments
	public function site_comments(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"comments\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sc=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sc="<can't grab site comments>";
		}
		return $sc;
	}

	# Site articles per page
	public function art_per_page(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"articles_per_page\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$apg=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$apg="<can't grab articles per page>";
		}
		return $apg;
	}

	# Tracking system
	public function tracking_system(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"tracking\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$ts=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$ts="<can't grab tracking system>";
		}
		return $ts;
	}

	# RSS feed
	public function rss(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"rss\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$rs=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$rs="<can't grab rss feed>";
		}
		return $rs;
	}

	# Sitemap
	public function sitemap(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"sitemap\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sm=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sm="<can't grab rss feed>";
		}
		return $sm;
	}

	# Am i admin or not
	public function is_admin(){
		if(isset($_SESSION['id_username'])){
			global $c;
			global $sessions;
			$dmp="SELECT type FROM cm_users WHERE us_id=\"$sessions->s_user_id\""; 
			if($d=$c->query($dmp)){
				while($r=$d->fetch_array(MYSQLI_ASSOC)){
					$isa=$r['type'];
					mysqli_free_result($d);
					break;
				}

				return (int)$isa;
			}
			else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}

	# Site under mod
	public function site_under_mod(){
		global $c;
		global $host_uri;
		global $options;

		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"under_mod\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sum=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sum=1; // If I can not grab value from database I will redirect to under moderation
		}
		#db_close($c);
		//echo host_uri();
		// Exit or not on site undermoderation
		if((int)$sum == 1)
		{
			if($host_uri->host_uri_noparm()==$options->site_host().'/login.php' || $options->is_admin()==1){
				//do absolutely nothing
			}
			else{
				if($host_uri->host_uri_noparm()!=$options->site_host().'/under_moderation.php'){
					exit(header("Location: ".$options->site_host()."/under_moderation.php"));
				}
			}
		}
	}

	# SMTP host
	public function smtp_host(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"smtp_host\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sh=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sh="<can't grab smtp host>";
		}
		return $sh;
	}

	# SMTP username
	public function smtp_username(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"smtp_username\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sh=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sh="<can't grab smtp username>";
		}
		return $sh;
	}

	# SMTP password
	public function smtp_passwd(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"smtp_passwd\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sh=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sh="<can't grab smtp password>";
		}
		return $sh;
	}

	# SMTP encryption
	public function smtp_secure(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"smtp_secure\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sh=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sh="<can't grab smtp encryption>";
		}
		return $sh;
	}

	# SMTP port
	public function smtp_port(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"smtp_port\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sh=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sh="<can't grab smtp port>";
		}
		return $sh;
	}

	# SMTP send email as
	public function smtp_send_as(){
		global $c;
		$dmp="SELECT option_value FROM cm_options WHERE option_name=\"smtp_send_as\"";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$sh=$r['option_value'];
				mysqli_free_result($d);
				break;
			}
		}
		else{
			$sh="<can't grab smtp send as email>";
		}
		return $sh;
	}

	# Check if user asked for post, page, search quest, user, category
	public function ContentCheck($asked)
	{
		switch($asked)
		{
			case "post": 
				if(isset($_GET['a']) && $this->CheckDirIfPanel())
				{
					return true;
				}
				else
				{
					return false;
				}
					break;
			case "page": 
				if(isset($_GET['p']) && $this->CheckDirIfPanel())
				{
					return true;
				}
				else
				{
					return false;
				}
					break;
			case "user": 
				if(isset($_GET['u']) && $this->CheckDirIfPanel())
				{
					return true;
				}
				else
				{
					return false;
				}
					break;
			case "category": 
				if(isset($_GET['c']) && $this->CheckDirIfPanel())
				{
					return true;
				}
				else
				{
					return false;
				}
					break;
			case "search": 
				if(isset($_GET['quest']) && $this->CheckDirIfPanel())
				{
					return true;
				}
				else
				{
					return false;
				}
					break;
			case "panel":
				if(!$this->CheckDirIfPanel())
				{
					return true;
				}
				else
				{
					return false;
				}
					break;
			default: 
				return false; 
				break;
		}
	}

	# Check if current directory is panel
	private function CheckDirIfPanel()
	{
		global $host_uri;
		global $options;

		if($host_uri->host_dir($host_uri->host_uri_noparm()) != $options->site_host().'/panel/')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	# Check script version
	public function CurrentVersion()
	{
		$content = file_get_contents('../panel/version', true);
		$version = trim(explode(":", $content)[1]);
		return $version;
	}

	public function CheckUpdate()
	{
		$content = file_get_contents('http://www.cidecode.com/version/cidecms');
		$current_version = explode(".", $this->CurrentVersion());
		$new_version = explode(".", trim(explode(":", $content)[1]));

		if($new_version > $current_version) return "New version is available, visit <a href=\"http://www.cidecode.com/cidecms\" target=\"_blank\">CideCMS update!</a>";
	}
}

# Try to create Options object
try
{
	$options = new Options();
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>