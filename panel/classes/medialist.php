<?php 

/*
 * This is a class for displaying media list.
 */

class MediaList extends Pagination 
{	
	public $pca;
	public $pagwr;
	public $gml;
	public $gu;

	public function __construct()
	{
		global $pagination;

		$this->CheckPerm();
		$this->pca = $this->MediaCount();
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->gml = $this->GrabMediaList();
		$this->gu = $this->GrabUsers();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->bmdr == 0){
			exit(header("Location: index.php"));
		}
	}

	# POST COUNT
	private function MediaCount()
	{
		global $c;

		$dmp="SELECT COUNT(*) FROM cm_media";
		if($d=$c->query($dmp))
		{
			while($v=$d->fetch_row()):
				$pca=$v[0];
			endwhile;
		}

		return $pca;
	}

	# GRAB POST LIST
	private function GrabMediaList(){	
		global $pagination;
		global $c;
		global $constants;
		$st = $this->st;
		$apg = $this->apg;

		$dmp="SELECT me_id as me,name as nm,description as dc,link as ln,media_type as mt,media_size as ms,upload_date as ud,active as ac 
			  FROM cm_media
			  ORDER BY upload_date DESC
			  LIMIT ".$constants::ITEMS_PER_PAGE." OFFSET $st";

		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}

	# JUMP ON IT POST ACTION
	public function ActionList($actionlist,$fileschecks)
	{
		global $c;

		# Selected action
		switch($actionlist){
			case 0: exit(header("Location: media.php?m=106")); break;
			case 1: $pac='delete'; break;
			case 2: $pac='activate'; break;
			case 3: $pac='deactivate'; break;
		}

		# Checking checked posts
		if(!empty($fileschecks)){
			foreach($fileschecks as $mc){
				# SQL dumping depending on choosed action
				if($pac == 'delete'){
					$dmp="DELETE FROM cm_media WHERE me_id=$mc";
				}
				else if($pac == 'activate'){
					$dmp="UPDATE cm_media SET active=1 WHERE me_id=$mc";
				}
				else if($pac == 'deactivate'){
					$dmp="UPDATE cm_media SET active=0 WHERE me_id=$mc";
				}
				 
				# Execute sql dumping
				$err_ary=array();
				$msq=$c->query($dmp);
				if(!$msq) $err_ary[]=1; 

			}
			
			if(!empty($err_ary)){
				exit(header("Location: media.php?m=107"));
			}
			else{
				exit(header("Location: media.php?m=6"));
			}
		}
		else{
			exit(header("Location: media.php?m=108"));
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
}

# Try to create MediaList object
try
{
	$medialist = new MediaList();

	if(isset($_POST['list_btn']))
	{
		$medialist->ActionList($_POST['list_action'],$_POST['files_checks']);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>