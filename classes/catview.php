<?php 

/*
 * This is class that will display all the posts
 * for selected category. Also this class must 
 * extend a class pagination.
 */

class CatView extends Pagination
{
	private $pca;
	public $pagwr;
	private $aac;
	public $cat_name;

	public function __construct($catid)
	{
		global $pagination;

		$this->CheckPerm();
		$this->pca = $this->PostCount($catid);
		$this->cat_name = $this->getCategoryName($catid);
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->aac = $this->getArticles($catid);
	}

	private function CheckPerm()
	{
		global $permission;
		global $options;

		# PERMISSION CHECK
		if($permission->fctr != 1){
			exit(header("Location: ".$options->site_host()));
		}
	}

	# What is the username
	private function getCategoryName($catid)
	{
		global $c;

		$dmp="SELECT cat_name as cn FROM cm_category WHERE ca_id=$catid"; 
		$d=$c->query($dmp);
		$v=$d->fetch_assoc();
		return $v['cn'];
	}


	# POST COUNT
	private function PostCount($catid)
	{
		global $c;
		
		$dmp="SELECT COUNT(*) FROM cm_posts WHERE type=0 AND active=1 AND category=$catid";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_row()):
				$pca=$v[0];
			endwhile;
		} 
		return $pca;
	}

	# Grab articles
	private function getArticles($catid){
		global $pagination;
		global $c;
		$st = $this->st;
		$apg = $this->apg;

		if($this->pca > 0){
		    $dmp="SELECT title as tt,content as ct,ca_id as ca,cat_name as cn,link as ln,p.active as ac,protect as pr,create_date as cd,
				  CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm,us_id as ui,comments as cm
				  FROM (cm_posts p INNER JOIN cm_users ON author=us_id) INNER JOIN cm_category ON category=ca_id 
		          WHERE p.type=0 AND p.active=1 AND category=$catid
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
		return $this->aac;
	}
}

# Try to create UserView object
try
{
	$catview = new CatView($_GET['c']);
}
catch(Exception $e)
{
	die($e->getMessages());
}

?>