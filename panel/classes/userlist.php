<?php 

/*
 * This is a class for displaying users.
 */

class UserList extends Pagination 
{
	public $pca;
	public $pagwr;
	public $gul;
	public $gu;
	public $gc;

	public function __construct()
	{
		global $pagination;

		$this->CheckPerm();
		$this->pca = $this->UserCount();
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->gul = $this->GrabUserList();
		$this->gu = $this->GrabUsers();
		$this->gc = $this->GrabCategories();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->busr == 0){
			exit(header("Location: index.php"));
		}
	}

	# POST COUNT
	private function UserCount()
	{
		global $c;

		$dmp="SELECT COUNT(*) FROM cm_users";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_row()):
				$pca=$v[0];
			endwhile;
		}

		return $pca;
	}
	

	# GRAB POST LIST
	private function GrabUserList(){	
		global $pagination;
		global $c;
		global $constants;
		$st = $this->st;
		$apg = $this->apg;

		$dmp="SELECT us_id as ui, username as un,user_email as ue,
			  join_date as jd,active as ac, type as tp,
			  CASE WHEN full_name IS NOT NULL THEN full_name ELSE '' END as fn,
			  CASE WHEN avatar IS NOT NULL THEN avatar ELSE 'none' END as ar,
			  CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as dn, 
			  CASE WHEN birth_date IS NOT NULL THEN birth_date ELSE 'DD.MM.YYYY' END as bd,
			  ut_id as us,status_name as sn,status_desc as sd
			  FROM cm_users u INNER JOIN cm_userstatus s ON u.type=s.ut_id
			  ORDER BY us_id 
			  LIMIT ".$constants::ITEMS_PER_PAGE." OFFSET $st";

		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}

	# JUMP ON IT POST ACTION
	public function ActionList($actionlist,$userchecks)
	{
		global $c;

		# Selected action
		switch($actionlist){
			case 0: exit(header("Location: users.php?m=106")); break;
			case 1: $pac='delete'; break;
			case 2: $pac='activate'; break;
			case 3: $pac='deactivate'; break;
		}

		# Checking checked posts
		if(!empty($userchecks)){
			foreach($userchecks as $pc){
				# SQL dumping depending on choosed action
				if($pac == 'delete'){
					$dmp="DELETE FROM cm_users WHERE us_id=$pc";
				}
				else if($pac == 'activate'){
					$dmp="UPDATE cm_users SET active=1 WHERE us_id=$pc";
				}
				else if($pac == 'deactivate'){
					$dmp="UPDATE cm_users SET active=0 WHERE us_id=$pc";
				}
				 
				# Execute sql dumping
				$err_ary=array();
				$msq=$c->query($dmp);
				if(!$msq) $err_ary[]=1;

			}
			
			if(!empty($err_ary)){
				exit(header("Location: users.php?m=107"));
			}
			else{
				exit(header("Location: users.php?m=6"));
			}
		}
		else{
			exit(header("Location: users.php?m=108"));
		}
	}

	# GRAB USERS
	function GrabUsers(){	
		global $c;

		$dmp="SELECT us_id,CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as name
			  FROM cm_users u INNER JOIN cm_userstatus s
		  	  ON u.type=s.ut_id
		  	  WHERE u.active=1 AND ut_id!=4";
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}

	# GRAB CATEGORIES
	function GrabCategories(){	
		global $c;

		$dmp="SELECT ca_id,cat_name
			  FROM cm_category";
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}
}

# Try to create UserList object
try
{
	$userlist = new UserList();

	if(isset($_POST['list_btn']))
	{
		$userlist->ActionList($_POST['list_action'],$_POST['users_checks']);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>