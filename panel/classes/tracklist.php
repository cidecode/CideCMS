<?php 

/*
 * This is a class for displaying tracking list
 */

class TrackList extends Pagination
{
	public $pca;
	public $pagwr;
	public $gtl;

	public function __construct()
	{
		global $pagination;

		$this->CheckPerm();
		$this->pca = $this->TrackCount();
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->gtl = $this->GrabTrackList();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->botr == 0){
			exit(header("Location: index.php"));
		}
	}

	private function TrackCount()
	{
		global $c;

		$dmp="SELECT COUNT(*) FROM cm_tracking";
		if($d=mysqli_query($c,$dmp)){
			while($v=mysqli_fetch_row($d)):
				$pca=$v[0];
			endwhile;
		}

		return $pca;
	}


	# GRAB POST LIST
	private function GrabTrackList(){	
		global $c;
		global $constants;
		$st = $this->st;

		$dmp="SELECT t.tr_id as ti,t.who as tw,t.what as th,t.when as tn,t.action as ac,CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm,us_id as ui 
			FROM cm_tracking t INNER JOIN cm_users u ON t.who=u.us_id
			ORDER BY t.when DESC
			LIMIT ".$constants::ITEMS_PER_PAGE." OFFSET $st"; 
		
		
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}

	# JUMP ON IT POST ACTION
	public function ActionList($actionlist,$trackchecks)
	{
		global $c;

		# Selected action
		switch($actionlist){
			case 0: exit(header("Location: tracking.php?m=106")); break;
			case 1: $pac='delete'; break;
		}

		# Checking checked logs
		if(!empty($trackchecks)){
			foreach($trackchecks as $lc){
				# SQL dumping depending on choosed action
				if($pac == 'delete'){
					$dmp="DELETE FROM cm_tracking WHERE tr_id=$lc";
				}
				 
				# Execute sql dumping
				$err_ary=array();
				$msq=$c->query($dmp);
				if(!$msq) $err_ary[]=1;

			}
			
			if(!empty($err_ary)){
				exit(header("Location: tracking.php?m=107"));
			}
			else{
				exit(header("Location: tracking.php?m=6"));
			}
		}
		else{
			exit(header("Location: tracking.php?m=108"));
		}
	}

}

# Try to create TrackList object
try
{
	$tracklist = new TrackList();

	if(isset($_POST['list_btn']))
	{
		$tracklist->ActionList($_POST['list_action'],$_POST['track_checks']);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>