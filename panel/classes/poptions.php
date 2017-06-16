<?php 

/*
 * This is a class for displaying options 
 */

class PanelOptions
{
	private $all_opt;
	private $acn;
	private $opt_err;
	public $gap;
	public $gas;
	public $gan;
									
	public function __construct()
	{
		$this->all_opt = array();
		$this->acn = 0;
		$this->opt_err = array();

		$this->CheckPerm();
		$this->gap = $this->GrabAllPerms();
		$this->gas = $this->GrabAdmins();
		$this->gan = $this->GrabAdminName($this->OptionValue('site_admin'));
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->botr == 0){
			exit(header("Location: index.php"));
		}
	}

	private function GetValuesFromDB()
	{
		global $c;

		$dmp="SELECT option_value as ov FROM cm_options";
		if($d=$c->query($dmp))
		{
			while($v=$d->fetch_assoc()){
				$this->all_opt[$this->acn++]=$v['ov'];	
			} 
		}
	}

	public function OptionValue($what)
	{ 

		$this->GetValuesFromDB(); 

		switch($what)
		{ 
			case "site_name": return $this->all_opt[0];
			case "site_desc": return $this->all_opt[1];
			case "site_admin": return $this->all_opt[2];
			case "site_email": return $this->all_opt[3];
			case "site_logo": return $this->all_opt[4];
			case "site_host": return $this->all_opt[5];
			case "site_theme": return $this->all_opt[6];
			case "site_footer": return $this->all_opt[7];
			case "site_mod": return $this->all_opt[10];
			case "articles_per_page": return $this->all_opt[11];
			case "site_com": return $this->all_opt[12];
			case "main_perm": return $this->all_opt[13];
			case "tracking": return $this->all_opt[14];
			case "site_rss": return $this->all_opt[15];
			//case "plugins": return $this->all_opt[16];
			case "sitemap": return $this->all_opt[17];
			case "smtp_host": return $this->all_opt[19];
			case "smtp_username": return $this->all_opt[20];
			case "smtp_secure": return $this->all_opt[22];
			case "smtp_port": return $this->all_opt[23];
			case "smtp_send_as": return $this->all_opt[24];
			#case "": return $this->all_opt[];
		}
	}

	private function InsertInDB($val,$what){
		global $c;

		$dmp="UPDATE cm_options SET option_value=\"$val\" WHERE option_name=\"$what\""; 
		if(!$c->query($dmp)){
			$this->opt_err[]=1;	
		}

		echo $c->error;
	}

	public function WriteValues()
	{

		# Site name
		$site_name=$_POST['site_name'];
		$this->InsertInDB($site_name,"site_name");
		# Site description
		$site_desc=$_POST['site_desc'];
		$this->InsertInDB($site_desc,"site_description");
		# Main site admin
		$site_admin=$_POST['site_admin'];
		$this->InsertInDB($site_admin,"site_admin");
		# Site email
		$site_email=$_POST['site_email'];
		$this->InsertInDB($site_email,"site_email");
		# Site logo
		if(isset($_FILES['upload']) && !empty($_FILES['upload']['name']))
			include('upload.inc');
		else
			$upl_res=$_POST['site_logo'];
		$this->InsertInDB($upl_res,"site_logo");
		# Site host
		$site_host=$_POST['site_host'];
		$this->InsertInDB($site_host,"site_host");
		# Articles per page
		$articles_per_page=$_POST['articles_per_page'];
		$this->InsertInDB($articles_per_page,"articles_per_page");
		# Site footer
		$site_footer=$_POST['site_footer'];
		$this->InsertInDB(addslashes($site_footer),"site_footer");
		# Site offline status (mod)
		if(isset($_POST['site_mod'])) $site_mod=1; else $site_mod=0;
		$this->InsertInDB($site_mod,"under_mod");
		# Site comments
		if(isset($_POST['site_com'])) $site_com=1; else $site_com=0;
		$this->InsertInDB($site_com,"comments");
		# Tracking system
		if(isset($_POST['tracking'])) $tracking=1; else $tracking=0;
		$this->InsertInDB($tracking,"tracking");
		# Site rss feed
		if(isset($_POST['site_rss'])) $site_rss=1; else $site_rss=0;
		$this->InsertInDB($site_rss,"rss");
		# Use plugins
		//if(isset($_POST['plugins'])) $plugins=1; else $plugins=0;
		//$this->InsertInDB($plugins,"plugins");
		# Site sitemap
		if(isset($_POST['sitemap'])) $sitemap=1; else $sitemap=0;
		$this->InsertInDB($sitemap,"sitemap");
		# Main permission
		$main_perm=$_POST['main_perm']; 
		$this->InsertInDB($main_perm,"main_perm");
		# SMTP host
		$smtp_host=$_POST['smtp_host']; 
		$this->InsertInDB($smtp_host,"smtp_host");
		# SMTP username
		$smtp_username=$_POST['smtp_username']; 
		$this->InsertInDB($smtp_username,"smtp_username");
		# SMTP passwd
		#$smtp_passwd=$_POST['smtp_passwd'];
		if(strlen($_POST['smtp_passwd']) > 0 && $_POST['smtp_passwd'] != ""){
			$smtp_passwd=str_replace('"', '""', $_POST['smtp_passwd']);
			$this->InsertInDB($smtp_passwd,"smtp_passwd");
		} 
		# SMTP secure
		$smtp_secure=$_POST['smtp_secure']; 
		$this->InsertInDB($smtp_secure,"smtp_secure");
		# SMTP port
		$smtp_port=$_POST['smtp_port']; 
		$this->InsertInDB($smtp_port,"smtp_port");
		# SMTP send as
		$smtp_send_as=$_POST['smtp_send_as']; 
		$this->InsertInDB($smtp_send_as,"smtp_send_as");
		
		// Checking if everything is alright
		if(empty($this->opt_err)){
			exit(header("Location: options.php?m=17"));
		}
		else{
			exit(header("Location: options.php?m=125"));
		}

	}


	# REMOVING LOGO
	public function RemoveLogo()
	{
		global $c;

		# Setting logo to NULL if is not set
		$dmp="UPDATE cm_options SET option_value=NULL WHERE option_name=\"site_logo\""; 
		if($c->query($dmp)){				
			exit(header("Location: options.php?m=16"));			
		}
		else
			exit(header("Location: options.php?m=124"));				
	}


	# GRAB ADMIM NAME
	private function GrabAdminName($id){	
		global $c;

		$dmp="SELECT username 
			  FROM cm_users 
			  WHERE us_id=$id";
		if($d=$c->query($dmp)){
			$v=$d->fetch_assoc();
			return $v['username'];
		}
		else 
			return false;
		
		$d->free_result();
	}

	# GRAB ADMINS
	private function GrabAdmins(){	
		global $c;

		$dmp="SELECT us_id,username 
			  FROM cm_users 
			  WHERE type=1";
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}

	# ALL PERMISSIONS
	private function GrabAllPerms(){	
		global $c;

		$dmp="SELECT ut_id,status_name 
			  FROM cm_userstatus";
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}

}

# Try to create Options object
try
{
	$paneloptions = new PanelOptions();

	if(isset($_POST['edit_options_btn']) && $permission->botw == 1)
	{
		$paneloptions->WriteValues();
	}

	if(isset($_GET['rm']) && $_GET['rm'] == 'logo' && isset($_GET['lg']))
	{
		$paneloptions->RemoveLogo();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}


?>