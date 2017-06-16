<?php 

/*
 * This is class that will display all the posts
 * for searched query. Also this class must 
 * extend a class pagination.
 */

class SearchView extends Pagination
{
	private $pca;
	public $pagwr;
	private $aas;
	public $quest;

	public function __construct()
	{
		global $pagination;

		$this->quest = $_GET['quest'];

		$this->CheckPerm();
		$this->pca = $this->PostCount();
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->aas = $this->getArticles();
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


	# POST COUNT
	private function PostCount()
	{
		global $c;
		global $options;
		
		if(strlen($this->quest) == 0 || $this->quest == ''){
			exit(header("Location: ".$options->site_host()));
		}

		$dmp="SELECT COUNT(*) FROM cm_posts WHERE active=1 AND (title LIKE \"%".$this->quest."%\" OR title LIKE \"".$this->quest."%\" OR title LIKE \"%".$this->quest."\" OR content LIKE \"%".$this->quest."%\" OR content LIKE \"".$this->quest."%\" OR content LIKE \"%".$this->quest."\")"; 

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

		if($this->pca > 0){
		    $dmp="SELECT title as tt,content as ct,link as ln,p.active as ac,protect as pr,create_date as cd,
			  CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm,us_id as ui,comments as cm
			  FROM (cm_posts p INNER JOIN cm_users ON author=us_id) 
	          WHERE p.active=1 AND (title LIKE \"%".$this->quest."%\" OR title LIKE \"".$this->quest."%\" OR title LIKE \"%".$this->quest."\" OR content LIKE \"%".$this->quest."%\" OR content LIKE \"".$this->quest."%\" OR content LIKE \"%".$this->quest."\")
	          ORDER BY cd DESC
	          LIMIT $apg OFFSET $st";  #LEFT OUTER JOIN cm_category ON category=ca_id 
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
		return $this->aas;
	}
}

# Try to create SearchView object
try
{
	$searchview = new SearchView();
}
catch(Exception $e)
{
	die($e->getMessages());
}

?>