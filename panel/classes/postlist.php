<?php 

/*
 * This is a class for displaying list of posts.
 */	

class PostList extends Pagination
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
		$this->pca = $this->PostCount();
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->gpl = $this->GrabPostList();
		$this->gu = $this->GrabUsers();
		$this->gc = $this->GrabCategories();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->bpsr == 0){
			exit(header("Location: index.php"));
		}
	}

	# POST COUNT
	private function PostCount()
	{
		global $c;

		$dmp="SELECT COUNT(*) FROM cm_posts WHERE type=0";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_row()):
				$pca=$v[0];
			endwhile;
		}

		return $pca;
	}

	# GRAB POST LIST
	private function GrabPostList(){	
		global $pagination;
		global $c;
		global $constants;
		$st = $this->st;
		$apg = $this->apg;

		if(isset($_GET['c'])){
			$cat=$_GET['c'];
			$dmp="SELECT po_id,title as tt,content as ct,cat_name as cn,link as ln,p.active as ac,protect as pr,
				  CASE WHEN create_date=modify_date THEN create_date ELSE modify_date END as dt,
				  CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm
				  FROM (cm_posts p INNER JOIN cm_category c ON category=c.ca_id) INNER JOIN cm_users u ON author=us_id
				  WHERE p.type=0 AND category=$cat
				  ORDER BY create_date DESC
				  LIMIT ".$constants::ITEMS_PER_PAGE." OFFSET $st";
		}
		else{
			$dmp="SELECT po_id,title as tt,content as ct,cat_name as cn,link as ln,p.active as ac,protect as pr,
				  CASE WHEN create_date=modify_date THEN create_date ELSE modify_date END as dt,
				  CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm
				  FROM (cm_posts p INNER JOIN cm_category c ON category=c.ca_id) INNER JOIN cm_users u ON author=us_id
				  WHERE p.type=0
				  ORDER BY create_date DESC
				  LIMIT ".$constants::ITEMS_PER_PAGE." OFFSET $st";
		}
		
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}

	# JUMP ON IT POST ACTION
	public function ActionList($actionlist,$postchecks)
	{
		global $c;

		# Selected action
		switch($actionlist){
			case 0: exit(header("Location: posts.php?m=106")); break;
			case 1: $pac='delete'; break;
			case 2: $pac='activate'; break;
			case 3: $pac='deactivate'; break;
		}

		# Checking checked posts
		if(!empty($postchecks)){
			foreach($postchecks as $pc){
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
				exit(header("Location: posts.php?m=107"));
			}
			else{
				# Create RSS feed
				#if(rss() == 1) include('../create_rss.inc');
				exit(header("Location: posts.php?m=6"));
			}
		}
		else{
			exit(header("Location: posts.php?m=108"));
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
	private function GrabCategories(){	
		global $c;

		$dmp="SELECT ca_id,cat_name
			  FROM cm_category";
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
	}
}

# Try to create PostList object
try
{
	$postlist = new PostList();

	if(isset($_POST['list_btn']))
	{
		$postlist->ActionList($_POST['list_action'],$_POST['posts_checks']);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}
?>