<?php 

/*
 * This is a class for displaying categories.
 */

class CategoryList extends Pagination
{
	public $pca;
	public $pagwr;
	public $gcl;

	public function __construct()
	{
		global $pagination;

		$this->CheckPerm();
		$this->pca = $this->CategoryCount();
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->gcl = $this->GrabCategoryList();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->bctr == 0){
			exit(header("Location: index.php"));
		}
	}

	# CATEGORIES COUNT
	private function CategoryCount()
	{
		global $c;

		$dmp="SELECT COUNT(*) FROM cm_category";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_row()):
				$pca=$v[0];
			endwhile;
		}

		return $pca;
	}


	# GRAB POST LIST
	private function GrabCategoryList(){	
		global $pagination;
		global $c;
		global $constants;
		$st = $this->st;
		$apg = $this->apg;

		$dmp="SELECT ca_id as ci,cat_name as cn,visible as vi,active as ac,(SELECT COUNT(*) FROM cm_posts WHERE category=ca_id) as pc
			  FROM cm_category
			  ORDER BY cat_name
			  LIMIT ".$constants::ITEMS_PER_PAGE." OFFSET $st";
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}

	# JUMP ON IT POST ACTION
	public function ActionList($actionlist,$catchecks)
	{
		global $c;

		# Selected action
		switch($actionlist){
			case 0: exit(header("Location: categories.php?m=106")); break;
			case 1: $pac='delete'; break;
			case 2: $pac='activate'; break;
			case 3: $pac='deactivate'; break;
			case 4: $pac='visible'; break;
			case 5: $pac='not_visible'; break;
		}

		# Checking checked posts
		if(!empty($catchecks)){
			foreach($catchecks as $cc){
				# SQL dumping depending on choosed action
				if($pac == 'delete'){
					$dmp="DELETE FROM cm_category WHERE po_id=$cc";
				}
				else if($pac == 'activate'){
					$dmp="UPDATE cm_category SET active=1 WHERE ca_id=$cc";
				}
				else if($pac == 'deactivate'){
					$dmp="UPDATE cm_category SET active=0 WHERE ca_id=$cc";
				}
				else if($pac == 'visible'){
					$dmp="UPDATE cm_category SET visible=1 WHERE ca_id=$cc";
				}
				else if($pac == 'not_visible'){
					$dmp="UPDATE cm_category SET visible=0 WHERE ca_id=$cc";
				}
				 
				# Execute sql dumping
				$err_ary=array();
				$msq=$c->query($dmp);
				if(!$msq) $err_ary[]=1;

			}
			
			if(!empty($err_ary)){
				exit(header("Location: categories.php?m=107"));
			}
			else{
				exit(header("Location: categories.php?m=6"));
			}
		}
		else{
			exit(header("Location: categories.php?m=108"));
		}
	}
}

# Try to create CategoryList object
try
{
	$catlist = new CategoryList();

	if(isset($_POST['list_btn']))
	{
		$catlist->ActionList($_POST['list_action'],$_POST['cat_checks']);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>