<?php 

/*
 * This class is for displaying choosen post.
 */

class PageView
{
	public $id;
	public $tt;
	public $ct;
	public $ln;
	public $ac;
	public $pr;
	public $cdd;
	public $cdt;
	public $nm;
	public $ui;
	public $cm;

	public function __construct($pageid)
	{
		$this->CheckPerm();
		$this->GrabPage($pageid);
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->fpgr == 0){
			exit(header("Location: index.php"));
		}
	}
	
	# PAGE VIEWING
	private function GrabPage($pageid)
	{
		$this->id = $pageid;

		global $c;

		if(isset($pageid) && $pageid > 0){

			# SQL dumping 
			$dmp="SELECT p.title as tt,p.content as ct,p.link as ln,p.active as ac,p.protect as pr,p.create_date as cd,
				  CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm,us_id as ui,p.comments as cm, p2.title as pnc
				  FROM (cm_posts p INNER JOIN cm_users u ON author=us_id) LEFT OUTER JOIN cm_posts p2 ON p.po_id=p2.parent
				  WHERE p.po_id=$pageid"; 

			if($d=$c->query($dmp)){
				while($v=$d->fetch_assoc()):
					$this->tt=$v['tt'];
					$this->ct=$v['ct'];
					$this->ln=$v['ln'];
					$this->ac=$v['ac'];
					$this->pr=$v['pr'];
					$this->cdd=date("d.m.Y",$v['cd']);
					$this->cdt=date("H:m",$v['cd']);
					$this->nm=$v['nm'];
					$this->ui=$v['ui'];
					$this->cm=$v['cm'];
					#$pnc=$v['pnc'];
					#$cop="under <b><a href=\"$ln\">$pnc</a></b>";

				endwhile;

				$d->free_result();

				if($this->ac == 0){
					exit(header("Location: index.php")); 
				}
			}

			if($this->ac == 0){
				exit(header("Location: index.php"));
			}
		}
		else{
			exit(header("Location: index.php"));
		}
	}
}

# Try to create PageView object
try
{
	$pview = new PageView($_GET['p']);
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>