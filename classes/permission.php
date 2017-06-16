<?php

/*
 * This is a class for manipulating permissions
 * over users and visitors. Custom scripting logic. 
 * Do not change this if your want it to work without mistake.
 */

class Permission
{
	private $perm; # Main permission

	# Front panel
	private $fin; # Index 
		public $finr;
		public $finw;
	private $fpg; # Pages
		public $fpgr;
		public $fpgw;
	private $fps; # Posts
		public $fpsr;
		public $fpsw;
	private $fcm; # Comments
		public $fcmr;
		public $fcmw;
	private $fus; # Users
		public $fusr;
		public $fusw;
	private $fct; # Categories
		public $fctr;
		public $fctw;
	private $frl; # Register / Login
		public $frlr;
		public $frlw;

	# Back panel
	private $bcp; # Control panel
		public $bcpr;
		public $bcpw;
	private $bpg; # Pages
		public $bpgr;
		public $bpgw;
	private $bps; # Posts
		public $bpsr;
		public $bpsw;
	private $bct; # Categories
		public $bctr;
		public $bctw;
	private $bcm; # Comments
		public $bcmr;
		public $bcmw;
	private $bmd; # Media
		public $bmdr;
		public $bmdw;
	private $bus; # Users
		public $busr;
		public $busw;
	private $brl; # Roles
		public $brlr;
		public $brlw;
	private $bth; # Themes
		public $bthr;
		public $bthw;
	private $bot; # Options
		public $botr;
		public $botw;
	private $bpu; # Plugins
		public $bpur;
		public $bpuw;

	# Direct links
	private $dl; # Direct links
		public $dlr;
		public $dlw;

	# Create constructor
	public function BuildSession($perm)
	{
		global $c;
		if($perm == null)
		{
			$dmp="SELECT user_perm FROM cm_userstatus WHERE ut_id=(SELECT option_value FROM cm_options WHERE option_name=\"main_perm\")"; 
			$d=$c->query($dmp); 
			$v=$d->fetch_assoc(); 

			$_SESSION['user_perm'] = $v['user_perm'];
			$this->perm = $_SESSION['user_perm'];
		}
		else
		{
			$this->perm = $perm;
		}

		# Set permissions
		$this->set_permissions();
	}


	# User permissions
	public function fp_split_section($index)
	{
		$fp=explode("/",$this->getPerm())[0];
		return explode(";",$fp)[$index];
	}
	public function bp_split_section($index)
	{
		$bp=explode("/",$this->getPerm())[1];
		return explode(";",$bp)[$index];
	}
	public function dl_split_section($index)
	{
		$dl=explode("/",$this->getPerm())[2];
		return explode(";",$dl)[$index];
	}
	public function split_rw($string,$index)
	{
		$vl=explode(":",$string)[1];
		return explode(",",$vl)[$index];
	}

	private function set_permissions()
	{
		// Front panel

			#! Index
			$this->fin=$this->fp_split_section(0);
				$this->finr=$this->split_rw($this->fin,0);
				$this->finw=$this->split_rw($this->fin,1);
			#! Pages
			$this->fpg=$this->fp_split_section(1);
				$this->fpgr=$this->split_rw($this->fpg,0);
				$this->fpgw=$this->split_rw($this->fpg,1);
			#! Posts
			$this->fps=$this->fp_split_section(2);
				$this->fpsr=$this->split_rw($this->fps,0);
				$this->fpsw=$this->split_rw($this->fps,1);
			#! Comments
			$this->fcm=$this->fp_split_section(3);
				$this->fcmr=$this->split_rw($this->fcm,0);
				$this->fcmw=$this->split_rw($this->fcm,1);
			#! Users
			$this->fus=$this->fp_split_section(4);
				$this->fusr=$this->split_rw($this->fus,0);
				$this->fusw=$this->split_rw($this->fus,1);
			#! Categories
			$this->fct=$this->fp_split_section(5);
				$this->fctr=$this->split_rw($this->fct,0);
				$this->fctw=$this->split_rw($this->fct,1);
			#! Reg_Log
			$this->frl=$this->fp_split_section(6);
				$this->frlr=$this->split_rw($this->frl,0);
				$this->frlw=$this->split_rw($this->frl,1);

		// Back panel

			#! Control_panel
			$this->bcp=$this->bp_split_section(0);
				$this->bcpr=$this->split_rw($this->bcp,0);
				$this->bcpw=$this->split_rw($this->bcp,1);
			#! Pages and widgets
			$this->bpg=$this->bp_split_section(1);
				$this->bpgr=$this->split_rw($this->bpg,0);
				$this->bpgw=$this->split_rw($this->bpg,1);
			#! Posts
			$this->bps=$this->bp_split_section(2);
				$this->bpsr=$this->split_rw($this->bps,0);
				$this->bpsw=$this->split_rw($this->bps,1);
			#! Categories
			$this->bct=$this->bp_split_section(3);
				$this->bctr=$this->split_rw($this->bct,0);
				$this->bctw=$this->split_rw($this->bct,1);
			#! Comments
			$this->bcm=$this->bp_split_section(4);
				$this->bcmr=$this->split_rw($this->bcm,0);
				$this->bcmw=$this->split_rw($this->bcm,1);
			#! Media
			$this->bmd=$this->bp_split_section(5);
				$this->bmdr=$this->split_rw($this->bmd,0);
				$this->bmdw=$this->split_rw($this->bmd,1);
			#! Users
			$this->bus=$this->bp_split_section(6);
				$this->busr=$this->split_rw($this->bus,0);
				$this->busw=$this->split_rw($this->bus,1);
			#! Roles
			$this->brl=$this->bp_split_section(7);
				$this->brlr=$this->split_rw($this->brl,0);
				$this->brlw=$this->split_rw($this->brl,1);
			#! Themes
			$this->bth=$this->bp_split_section(8);
				$this->bthr=$this->split_rw($this->bth,0);
				$this->bthw=$this->split_rw($this->bth,1);
			#! Options
			$this->bot=$this->bp_split_section(9);
				$this->botr=$this->split_rw($this->bot,0);
				$this->botw=$this->split_rw($this->bot,1);
			#! Plugins
			$this->bpu=$this->bp_split_section(10);
				$this->bpur=$this->split_rw($this->bpu,0);
				$this->bpuw=$this->split_rw($this->bpu,1);

		// Direct links
		$this->dl=$this->dl_split_section(0);
				$this->dlr=$this->split_rw($this->dl,0);
				$this->dlw=$this->split_rw($this->dl,1);

	}

		

	# Get permission values
	public function getPerm()
	{
		return $this->perm;
	}

	public function setPerm($newval)
	{
		$this->perm = $newval;
	}			
		
	# Permissions check up function
	public function perm_check_up($val_r,$val_w,$page,$solt)
	{
		global $options;

		if($val_r != 1){
			if($solt == 'pagedie'){
				die('You don\'t have permission to view this site!');
			}
			else{
				#exit(header("Location: ".$options->site_host()."$page"));
			}
		}
		else if($val_w != 1 && !isset($_GET['ol'])){
			#exit(header("Location: $page.php?m=129&ol=true".$solt));
		}
	}

	# Disable form button if user does not have permission to write
	public function perm_btn_disable($val_w)
	{
		if($val_w != 1) echo "disabled style=\"cursor: default; background-color: #ccc;\"";
		else echo "";
	}
		

	# Return checkbox status (exp: checked)
	public function checkbox_status($val)
	{
		if($val == 1) echo "checked";
	}

	public function is_admin_footer()
	{
		if($this->bcpr == 1){
			$is_adm="<a href=\"panel\">Admin panel</a>";
		}	
		else{
			$is_adm="";
		}
		echo $is_adm;
	}
}

# Try to create permission object
try
{
	$permission = new Permission();

	if(isset($_SESSION['user_perm']))
	{
		$permission->BuildSession($_SESSION['user_perm']);
	}
	else
	{
		$permission->BuildSession(null);
	}
	
}
catch(Exception $e)
{
	die($e->getMessage());
}


?>