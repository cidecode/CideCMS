<?php 

/*
 * This class is for displaying choosen post.
 */

class PostView
{
	public $id;
	public $tt;
	public $ct;
	public $ca;
	public $cn;
	public $ln;
	public $pr;
	public $cdd;
	public $cdt;
	public $nm;
	public $ui;
	public $cm;
	public $cop;
	public $test;

	public function __construct()
	{ $test = "sss";
		$this->CheckPerm();
		$this->GrabPost();

	}

	# PERMISSION CHECK UP
	private function CheckPerm()
	{
		global $permission;

		if($permission->fpsr == 0){
			exit(header("Location: index.php"));
		}
	}

	# POST VIEWING
	private function GrabPost()
	{
		global $c;

		if(isset($_GET['a'])) $this->id = $_GET['a'];
		else if(isset($_GET['pi'])) $this->id = $_GET['pi'];
		

		if(isset($this->id) && $this->id > 0){

			

			# SQL dumping 
			$dmp="SELECT title as tt,content as ct,ca_id as ca,cat_name as cn,link as ln,p.active as ac,protect as pr,create_date as cd,
				  CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as nm,us_id as ui,comments as cm
				  FROM (cm_posts p INNER JOIN cm_category c ON category=c.ca_id) INNER JOIN cm_users u ON author=us_id
				  WHERE po_id=$this->id"; 

			if($d=$c->query($dmp)){
				while($v=$d->fetch_assoc()):
					$this->tt=$v['tt'];
					$this->ct=$v['ct'];
					$this->ca=$v['ca'];
					$this->cn=$v['cn'];
					$this->ln=$v['ln'];
					$this->ac=$v['ac'];
					$this->pr=$v['pr'];
					$this->cdd=date("d.m.Y",$v['cd']);
					$this->cdt=date("H:m",$v['cd']);
					$this->nm=$v['nm'];
					$this->ui=$v['ui'];
					$this->cm=$v['cm'];
					$this->cop="in <b><a href=\"category.php?c=".$this->ca."\">".$this->cn."</a></b>";
					
				endwhile;
				
				$d->free_result();


				if($this->ac == 0){
					exit(header("Location: index.php")); 
				}
			}

		}
		else{ 
			exit(header("Location: index.php"));
		}
	}
}

# Try to create PostView object
try
{
	$pview = new PostView();
}
catch(Exception $e)
{
	die($e->getMessage());
}


?>