<?php 

/*
 * This is class that will display all the posts
 * for selected user. Also this class must 
 * extend a class pagination.
 */

class UserView extends Pagination
{
	private $pca;
	public $pagwr;
	private $aabu;
	public $username;

	public function __construct($userid)
	{
		global $pagination;

		$this->CheckPerm();
		$this->pca = $this->PostCount($userid);
		$this->username = $this->getUsername($userid);
		$this->pagwr = $this->CalculatePagination($this->pca); 
		$this->aabu = $this->getArticles($userid); 
	}

	private function CheckPerm()
	{
		global $permission;
		global $options;

		# PERMISSION CHECK
		if($permission->fusr != 1){
			exit(header("Location: ".$options->site_host()));
		}
	}

	# What is the username
	private function getUsername($userid)
	{
		global $c;

		$dmp="SELECT CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm FROM cm_users WHERE us_id=$userid"; 
		$d=$c->query($dmp);
		$v=$d->fetch_assoc();
		return $v['nm'];
	}


	# POST COUNT
	private function PostCount($userid)
	{
		global $c;
		
		$dmp="SELECT COUNT(*) FROM cm_posts WHERE type=0 AND active=1 AND author=$userid"; 
		if($d=$c->query($dmp)){
			while($v=$d->fetch_row()):
				$pca=$v[0];
			endwhile;
		}
		return $pca;
	}

	# Grab articles
	private function getArticles($userid){
		global $pagination;
		global $c;
		$st = $this->st;
		$apg = $this->apg;

		if($this->pca > 0){
		    $dmp="SELECT title as tt,content as ct,ca_id as ca,cat_name as cn,link as ln,p.active as ac,protect as pr,create_date as cd,
				  CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm,us_id as ui,comments as cm
				  FROM (cm_posts p INNER JOIN cm_users ON author=us_id) INNER JOIN cm_category ON category=ca_id 
		          WHERE p.type=0 AND p.active=1 AND author=$userid
		          ORDER BY create_date DESC
		          LIMIT $apg OFFSET $st"; 
			if($d=$c->query($dmp)){
				return $d;
			}
			else{
				$sn="<can't grab articles>";
				return false;
			}
			$d->free_result();
		}
		else{
			return false;
		}
	}

	public function all_articles(){
		return $this->aabu;
	}
}

# Try to create UserView object
try
{
	$userview = new UserView($_GET['u']);
}
catch(Exception $e)
{
	die($e->getMessages());
}

?>