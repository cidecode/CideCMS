<?php 

/*
 * This is a class for displaying widgets.
 */

class WidgetList extends Pagination 
{
	public $pca;
	public $pagwr;
	public $gwl;

	public function __construct()
	{
		global $pagination;

		$this->CheckPerm();
		$this->pca = $this->WidgetCount();
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->gwl = $this->GrabWidgetList();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->bpgr == 0){
			exit(header("Location: index.php"));
		}
	}

	# WIDGET COUNT
	private function WidgetCount()
	{
		global $c;

		$dmp="SELECT COUNT(*) FROM cm_widgets";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_row()):
				$pca=$v[0];
			endwhile;
		}

		return $pca;
	}

	# GRAB WIDGET LIST
	private function GrabWidgetList(){	
		global $pagination;
		global $c;
		global $constants;
		$st = $this->st;
		$apg = $this->apg;

		$dmp="SELECT wi_id as wi,title as tt,content as ct,active as ac
			  FROM cm_widgets
			  LIMIT ".$constants::ITEMS_PER_PAGE." OFFSET $st";
		  
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}
	


	# JUMP ON IT PAGE ACTION
	public function ActionList($actionlist,$widgetchecks)
	{
		global $c;

		# Selected action
		switch($actionlist){
			case 0: exit(header("Location: widgets.php?m=106")); break;
			case 1: $pac='delete'; break;
			case 2: $pac='activate'; break;
			case 3: $pac='deactivate'; break;
		}

		# Checking checked pages
		if(!empty($widgetchecks)){
			foreach($widgetchecks as $pc){
				# SQL dumping depending on choosed action
				if($pac == 'delete'){
					$dmp="DELETE FROM cm_widgets WHERE wi_id=$pc";
				}
				else if($pac == 'activate'){
					$dmp="UPDATE cm_widgets SET active=1 WHERE wi_id=$pc";
				}
				else if($pac == 'deactivate'){
					$dmp="UPDATE cm_widgets SET active=0 WHERE wi_id=$pc";
				}
				 
				# Execute sql dumping
				$err_ary=array();
				$msq=$c->query($dmp);
				if(!$msq) $err_ary[]=1;

			}
			
			if(!empty($err_ary)){
				exit(header("Location: widgets.php?m=107"));
			}
			else{
				exit(header("Location: widgets.php?m=6"));
			}
		}
		else{
			exit(header("Location: widgets.php?m=108"));
		}
	}
}

# Try to create WidgetList object
try
{
	$widgetlist = new WidgetList();

	if(isset($_POST['list_btn']))
	{
		$widgetlist->ActionList($_POST['list_action'],$_POST['widget_checks']);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>