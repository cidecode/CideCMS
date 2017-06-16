<?php 

/*
 * This is class that will display all the posts
 * to home page. Also this class must extend a
 * a class pagination.
 */


class Home extends Pagination
{
	private $pca;
	public $pagwr;
	private $aa;

	public function __construct()
	{
		global $pagination;

		$this->pca = $this->PostCount();
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->aa = $this->getArticles();
	}

	# POST COUNT
	private function PostCount()
	{
		global $c;
		$dmp="SELECT COUNT(*) FROM cm_posts WHERE type=0 AND active=1";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_row()):
				$pca=$v[0];
			endwhile;
		}
		return $pca;
	}

	# Grab articles
	private function getArticles(){
		global $pagination;
		global $c;
		$st = $this->st;
		$apg = $this->apg;

		$dmp="SELECT title as tt,content as ct,ca_id as ca,cat_name as cn,link as ln,p.active as ac,protect as pr,create_date as cd,
			  CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm,us_id as ui,comments as cm
			  FROM (cm_posts p INNER JOIN cm_users ON author=us_id) INNER JOIN cm_category ON category=ca_id 
	          WHERE p.type=0 AND p.active=1
	          ORDER BY create_date DESC
	          LIMIT $apg OFFSET $st";
		if($d=$c->query($dmp)){
			return $d;
		}
		else{
			$sn="<can't grab articles>";
			return false;
		}
		mysqli_free_result($d);
	}

	public function all_articles(){
		return $this->aa;
	}
}

# Try to create Home object
try
{
	$home = new Home();
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>