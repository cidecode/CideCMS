<?php 

/*
 * This is a class for adding new role
 */

class AddRole
{
	public function __construct()
	{
		$this->CheckPerm();
	} 

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->brlr,$permission->brlw,'addrole','');
	}


	# EDITING THE ROLE
	public function NewRole()
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
		$dmp="INSERT INTO cm_userstatus VALUES('',\"$role_name\",\"$role_desc\",\"$user_perm\")";
		if($c->query($dmp)){
			$last_id=$c->insert_id;

			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('role',$role_name,'INSERT');
			}

			# Redirection to addrole.php
			exit(header("Location: editrole.php?r=$last_id&m=19"));
			
		}
		else{
			# Redirection to addrole.php
			exit(header("Location: addrole.php?m=131"));
		}

	}
}

# Try to create AddRole object
try
{
	$addrole = new AddRole();

	if(isset($_POST['add_role_btn']))
	{
		$addrole->NewRole();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}


?>