<?php 

/*
 * This is a class for editing roles
 */

class EditRole
{	
	public $id;
	public $sn;
	public $sd;

	public $c_finr;
	public $c_finw;
	public $c_fpgr;
	public $c_fpgw;
	public $c_fpsr;
	public $c_fpsw;
	public $c_fcmr;
	public $c_fcmw;
	public $c_fusr;
	public $c_fusw;
	public $c_fctr;
	public $c_fctw;
	public $c_frlr;
	public $c_frlw;
	public $c_bcpr;
	public $c_bcpw;
	public $c_bpgr;
	public $c_bpgw;
	public $c_bpsr;
	public $c_bpsw;
	public $c_bctr;
	public $c_bctw;
	public $c_bcmr;
	public $c_bcmw;
	public $c_bmdr;
	public $c_bmdw;
	public $c_busr;
	public $c_busw;
	public $c_brlr;
	public $c_brlw;
	public $c_bthr;
	public $c_bthw;
	public $c_botr;
	public $c_botw;
	public $c_bpur;
	public $c_bpuw;

	public function __construct()
	{
		$this->CheckPerm();

		if(isset($_GET['r']))
		{
			$this->ViewRole();
		}
		else
		{
			exit(header("Location: index.php"));
		}
	} 

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->brlr,$permission->brlw,'editrole','&r='.$_GET['r']);
	}


	# GRAB THE POST ID FOR EDITING
	private function ViewRole()
	{
		global $c;

		$this->id=$_GET['r'];

		$dmp="SELECT ut_id as ui, status_name as sn, status_desc as sd,user_perm as up,(SELECT COUNT(*) FROM cm_users WHERE type=ut_id) as un 
			  FROM cm_userstatus 
			  WHERE ut_id=$this->id";
		if($d=$c->query($dmp))
		{
			while($v=$d->fetch_assoc()){
				$this->sn=$v['sn'];
				$this->sd=$v['sd'];
				$perm=$v['up']; 
				$un=$v['un']; 
			}

			$roleperm = new Permission();
			$roleperm->setPerm($perm);
				#
				# PERMISSIONS 
				#
				/*function c_fp_split_section($index){
					global $perm;
					$fp=explode("/",$perm)[0];
					return explode(";",$fp)[$index];
				}
				function c_bp_split_section($index){
					global $perm;
					$bp=explode("/",$perm)[1];
					return explode(";",$bp)[$index];
				}
				function c_split_rw($string,$index){
					$vl=explode(":",$string)[1];
					return explode(",",$vl)[$index];
				}*/

				// Front panel

					#! Index
					$c_fin=$roleperm->fp_split_section(0);
						$this->c_finr=$roleperm->split_rw($c_fin,0);
						$this->c_finw=$roleperm->split_rw($c_fin,1);
					#! Pages
					$c_fpg=$roleperm->fp_split_section(1);
						$this->c_fpgr=$roleperm->split_rw($c_fpg,0);
						$this->c_fpgw=$roleperm->split_rw($c_fpg,1);
					#! Posts
					$c_fps=$roleperm->fp_split_section(2);
						$this->c_fpsr=$roleperm->split_rw($c_fps,0);
						$this->c_fpsw=$roleperm->split_rw($c_fps,1);
					#! Comments
					$c_fcm=$roleperm->fp_split_section(3);
						$this->c_fcmr=$roleperm->split_rw($c_fcm,0);
						$this->c_fcmw=$roleperm->split_rw($c_fcm,1);
					#! Users
					$c_fus=$roleperm->fp_split_section(4);
						$this->c_fusr=$roleperm->split_rw($c_fus,0);
						$this->c_fusw=$roleperm->split_rw($c_fus,1);
					#! Categories
					$c_fct=$roleperm->fp_split_section(5);
						$this->c_fctr=$roleperm->split_rw($c_fct,0);
						$this->c_fctw=$roleperm->split_rw($c_fct,1);
					#! Reg_Log
					$c_frl=$roleperm->fp_split_section(6);
						$this->c_frlr=$roleperm->split_rw($c_frl,0);
						$this->c_frlw=$roleperm->split_rw($c_frl,1);

				// Back panel

					#! Control_panel
					$c_bcp=$roleperm->bp_split_section(0);
						$this->c_bcpr=$roleperm->split_rw($c_bcp,0);
						$this->c_bcpw=$roleperm->split_rw($c_bcp,1);
					#! Pages
					$c_bpg=$roleperm->bp_split_section(1);
						$this->c_bpgr=$roleperm->split_rw($c_bpg,0);
						$this->c_bpgw=$roleperm->split_rw($c_bpg,1);
					#! Posts
					$c_bps=$roleperm->bp_split_section(2);
						$this->c_bpsr=$roleperm->split_rw($c_bps,0);
						$this->c_bpsw=$roleperm->split_rw($c_bps,1);
					#! Categories
					$c_bct=$roleperm->bp_split_section(3);
						$this->c_bctr=$roleperm->split_rw($c_bct,0);
						$this->c_bctw=$roleperm->split_rw($c_bct,1);
					#! Comments
					$c_bcm=$roleperm->bp_split_section(4);
						$this->c_bcmr=$roleperm->split_rw($c_bcm,0);
						$this->c_bcmw=$roleperm->split_rw($c_bcm,1);
					#! Media
					$c_bmd=$roleperm->bp_split_section(5);
						$this->c_bmdr=$roleperm->split_rw($c_bmd,0);
						$this->c_bmdw=$roleperm->split_rw($c_bmd,1);
					#! Users
					$c_bus=$roleperm->bp_split_section(6);
						$this->c_busr=$roleperm->split_rw($c_bus,0);
						$this->c_busw=$roleperm->split_rw($c_bus,1);
					#! Roles
					$c_brl=$roleperm->bp_split_section(7);
						$this->c_brlr=$roleperm->split_rw($c_brl,0);
						$this->c_brlw=$roleperm->split_rw($c_brl,1);
					#! Themes
					$c_bth=$roleperm->bp_split_section(8);
						$this->c_bthr=$roleperm->split_rw($c_bth,0);
						$this->c_bthw=$roleperm->split_rw($c_bth,1);
					#! Options
					$c_bot=$roleperm->bp_split_section(9);
						$this->c_botr=$roleperm->split_rw($c_bot,0);
						$this->c_botw=$roleperm->split_rw($c_bot,1);
					#! Plugins
					$c_bpu=$roleperm->bp_split_section(10);
						$this->c_bpur=$roleperm->split_rw($c_bpu,0);
						$this->c_bpuw=$roleperm->split_rw($c_bpu,1); 
		}
		else{
			return "<can not grab the role>";
		}

	} 

	# Return checkbox status (exp: checked)
	public function checkbox_status($val)
	{
		if($val == 1) echo "checked";
	}

	# EDITING THE ROLE
	public function Edit()
	{
		global $c;
		global $options;
		global $tracking;

		# Role name
		$role_name=$_POST['role_name'];
		# Role description
		$role_desc=$_POST['role_desc'];
		# Role section array
		$role_section=array("in","pg","ps","cm","ue","ct","rl","cp","pg","ps","ct","cm","md","ue","rl","te","ot","pu","dm");
		# Role box values
		$roles_box=$_POST['roles_box'];
		
		$b=0;
		$user_perm="";
		$rl_gone=false;
		foreach($role_section as $rosec){
			$user_perm.=$rosec.":";

			for($z=$b; $z<36; $z++){
				if(isset($roles_box[$z])) $role_val=1; else $role_val=0;
				$user_perm.=$role_val;
				if($b+1 == $z){
					$b+=2;
					if($rosec == "rl" && !$rl_gone){
						$user_perm.="/";
						$rl_gone=!$rl_gone;
					}
					else if($rosec == "pu"){
						$user_perm.="/";
					}
					else{
						if($rosec != "dm"){
							$user_perm.=";";
						}
					}
					break;
				}
				else{
					$user_perm.=",";
				}
			}

			if($rosec == "dm"){
				$user_perm.="1,1";
			}
		} 

		# SQL dumping = cm_userstatus 
		$dmp="UPDATE cm_userstatus
			SET
				status_name=\"$role_name\",
				status_desc=\"$role_desc\",
				user_perm=\"$user_perm\"
			WHERE ut_id=$this->id";
		if($c->query($dmp)){
			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('role',$role_name,'UPDATE');
			}

			# Redirection to editrole.php
			exit(header("Location: editrole.php?r=$this->id&m=18"));
			
		}
		else{
			# Redirection to editrole.php
			exit(header("Location: editrole.php?r=$this->id&m=130"));
		}

	}
}

# Try to create EditRole object
try
{
	$editrole = new EditRole();

	if(isset($_POST['edit_role_btn']))
	{
		$editrole->Edit();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>