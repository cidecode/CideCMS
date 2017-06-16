<?php 

/*
 * This is a class for displaying pages.
 */

class PageList extends Pagination
{
	
	public $pca;
	public $pagwr;
	public $gpl;
	public $gu;
	public $gc;

	public function __construct()
	{
		global $pagination;
		$this->CheckPerm();
		$this->pca = $this->PageCount();
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->gpl = $this->GrabPageList();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->bpgr == 0){
			exit(header("Location: index.php"));
		}
	}

	# PAGE COUNT
	private function PageCount()
	{
		global $c;

		$dmp="SELECT COUNT(*) FROM cm_posts WHERE type=1";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_row()):
				$pca=$v[0];
			endwhile;
		}

		return $pca;
	}

	# GRAB PAGE LIST
	private function GrabPageList(){	
		global $pagination;
		global $c;
		global $constants;
		$st = $this->st;
		$apg = $this->apg;

		/*$dmp="SELECT po_id,title as tt,content as ct,link as ln,p.active as ac,protect as pr,
			  CASE WHEN create_date=modify_date THEN create_date ELSE modify_date END as dt,
			  CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm,
              CASE WHEN parent=0 THEN 'none' ELSE (SELECT p1.title FROM cm_posts p1 INNER JOIN cm_posts p2 ON p1.po_id=p2.parent) END as pn
			  FROM (cm_posts p INNER JOIN cm_users u ON author=us_id) 
			  WHERE p.type=1
			  ORDER BY create_date DESC
			  LIMIT ".ITEMS_PER_PAGE." OFFSET $st"; # Query returns more then 1 result*/

		$dmp="SELECT p.po_id,p.title as tt,p.content as ct,p.link as ln,p.active as ac,p.protect as pr,
			  CASE WHEN p.create_date=p.modify_date THEN p.create_date ELSE p.modify_date END as dt,
			  CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm,
              CASE WHEN p.parent=0 THEN 'none' ELSE p.parent END as pn
			  FROM (cm_posts p INNER JOIN cm_users u ON author=us_id) 
			  WHERE p.type=1
			  ORDER BY p.create_date DESC
			  LIMIT ".$constants::ITEMS_PER_PAGE." OFFSET $st";
		  
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}
	


	# JUMP ON IT PAGE ACTION
	public function ActionList($actionlist,$pagechecks)
	{
		global $c;
		
		# Selected action
		switch($actionlist){
			case 0: exit(header("Location: pages.php?m=106")); break;
			case 1: $pac='delete'; break;
			case 2: $pac='activate'; break;
			case 3: $pac='deactivate'; break;
		}

		# Checking checked pages
		if(!empty($pagechecks)){
			foreach($pagechecks as $pc){
				# SQL dumping depending on choosed action
				if($pac == 'delete'){
					$dmp="DELETE FROM cm_posts WHERE po_id=$pc";
				}
				else if($pac == 'activate'){
					$dmp="UPDATE cm_posts SET active=1 WHERE po_id=$pc";
				}
				else if($pac == 'deactivate'){
					$dmp="UPDATE cm_posts SET active=0 WHERE po_id=$pc";
				}
				 
				# Execute sql dumping
				$err_ary=array();
				$msq=$c->query($dmp);
				if(!$msq) $err_ary[]=1;

			}
			
			if(!empty($err_ary)){
				exit(header("Location: pages.php?m=107"));
			}
			else{
				exit(header("Location: pages.php?m=6"));
			}
		}
		else{
			exit(header("Location: pages.php?m=108"));
		}
	}

	# GRAB USERS
	private function GrabUsers(){	
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
	function grab_categories(){	
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

# Try to create PageList object
try
{
	$pagelist = new PageList();

	if(isset($_POST['list_btn']))
	{
		$pagelist->ActionList($_POST['list_action'],$_POST['page_checks']);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>