<?php 

/*
 * This is a class for displaying comments.
 */

class CommentsList extends Pagination
{
	public $pca;
	public $pagwr;
	public $gcl;

	public function __construct()
	{
		global $pagination;

		$this->CheckPerm();
		$this->pca = $this->CommentCount();
		$this->pagwr = $this->CalculatePagination($this->pca);
		$this->gcl = $this->GrabCommentsList();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->bcmr == 0){
			exit(header("Location: index.php"));
		}
	}

	# COMMENTS COUNT
	private function CommentCount()
	{
		global $c;

		$dmp="SELECT COUNT(*) FROM cm_comments";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_row()):
				$pca=$v[0];
			endwhile;
		}

		return $pca;
	}

	# GRAB COMMENTS LIST
	private function GrabCommentsList(){	
		global $pagination;
		global $c;
		global $constants;
		$st = $this->st;
		$apg = $this->apg;

		
		$dmp="SELECT co_id as ci,c.content as ct,c.full_name as fn,email as em,c.create_date as cd,
			  CASE WHEN user_id IS NOT NULL THEN username ELSE 'anonymous' END AS un,post_id as pi, 
			  c.active as ac,nickname as nk,title as tl,link as ln
			  FROM (cm_comments as c LEFT OUTER JOIN cm_posts as p ON c.post_id=p.po_id) LEFT OUTER JOIN cm_users as u ON c.user_id=u.us_id
			  ORDER BY c.create_date DESC
			  LIMIT ".$constants::ITEMS_PER_PAGE." OFFSET $st"; 

		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
		
	}
	

	# JUMP ON IT POST ACTION
	public function ActionList($actionlist,$comchecks)
	{
		global $c;

		# Selected action
		switch($actionlist){
			case 0: exit(header("Location: comments.php?m=106")); break;
			case 1: $pac='delete'; break;
			case 2: $pac='activate'; break;
			case 3: $pac='deactivate'; break;
		}

		# Checking checked posts
		if(!empty($comchecks)){
			foreach($comchecks as $cc){
				# SQL dumping depending on choosed action
				if($pac == 'delete'){
					$dmp="DELETE FROM cm_comments WHERE co_id=$cc";
				}
				else if($pac == 'activate'){
					$dmp="UPDATE cm_comments SET active=1 WHERE co_id=$cc";
				}
				else if($pac == 'deactivate'){
					$dmp="UPDATE cm_comments SET active=0 WHERE co_id=$cc";
				}
				 
				# Execute sql dumping
				$err_ary=array();
				$msq=$c->query($dmp);
				if(!$msq) $err_ary[]=1;

			}
			
			if(!empty($err_ary)){
				exit(header("Location: comments.php?m=107"));
			}
			else{
				exit(header("Location: comments.php?m=6"));
			}
		}
		else{
			exit(header("Location: comments.php?m=108"));
		}
	}
}

# Try to create CommentsList object
try
{
	$comlist = new CommentsList();

	if(isset($_POST['list_btn']))
	{
		$comlist->ActionList($_POST['list_action'],$_POST['comments_checks']);
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

	

?>