<?php 

/*
 * This is a class for displaying roles.
 */

class RoleList extends Pagination 
{
	public $pca;
	public $pagwr;
	public $grl;

	public function __construct()
	{
		global $pagination;

		$this->CheckPerm();
		$this->pca = $this->RoleCount();
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->grl = $this->GrabRoleList();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->brlr == 0){
			exit(header("Location: index.php"));
		}
	}
	# ROLES COUNT
	private function RoleCount()
	{
		global $c;

		$dmp="SELECT COUNT(*) FROM cm_userstatus";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_row()):
				$pca=$v[0];
			endwhile;
		}

		return $pca;
	}


	# GRAB POST LIST
	private function GrabRoleList(){	
		global $pagination;
		global $c;
		global $constants;
		$st = $this->st;
		$apg = $this->apg;

		$dmp="SELECT ut_id as ui, status_name as sn, status_desc as sd,(SELECT COUNT(*) FROM cm_users WHERE type=ut_id) as un 
			  FROM cm_userstatus
			  LIMIT ".$constants::ITEMS_PER_PAGE." OFFSET $st";
		
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}

	# JUMP ON IT POST ACTION
	public function ActionList($actionlist,$rolechecks)
	{
		global $c;

		# Selected action
		switch($actionlist){
			case 0: exit(header("Location: roles.php?m=106")); break;
			case 1: $pac='delete'; break;
			case 2: $pac='activate'; break;
			case 3: $pac='deactivate'; break;
		}

		# Checking checked posts
		if(!empty($rolechecks)){
			foreach($rolechecks as $rc){
				# SQL dumping depending on choosed action
				if($pac == 'delete'){
					$dmp="DELETE FROM cm_userstatus WHERE ut_id=$rc";
				}
				 
				# Execute sql dumping
				$err_ary=array();
				$msq=$c->query($dmp);
				if(!$msq) $err_ary[]=1;

			}
			
			if(!empty($err_ary)){
				exit(header("Location: roles.php?m=107"));
			}
			else{
				exit(header("Location: roles.php?m=6"));
			}
		}
		else{
			exit(header("Location: roles.php?m=108"));
		}
	}
}

# Try to create RoleList object
try
{
	$rolelist = new RoleList();

	if(isset($_POST['list_btn']))
	{
		$rolelist->ActionList($_POST['list_action'],$_POST['role_check']);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}	

?>