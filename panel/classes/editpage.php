<?php 

/*
 * This is a class for editing page
 */

class EditPage
{
	public $id;
	public $pt;
	public $pc;
	public $pl;
	public $pcd;
	public $pmd;
	public $ui;
	public $un;	
	public $pr;
	public $cm;
	public $ppi;
	public $pps;
	public $pcm;
	public $paa;
	public $ppp;
	public $gu;
	public $gc;

	public function __construct()
	{
		$this->CheckPerm();
		$this->gu = $this->GrabUsers();
		$this->gp = $this->GrabParents();

		if(isset($_GET['p']))
		{
			$this->ViewPage();
		}
		else
		{
			exit(header("Location: index.php"));
		}
	} 

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->bpgr,$permission->bpgw,'editpage','&p='.$_GET['p']);
	}

	# GRAB THE PAGE ID FOR EDITING
	private function ViewPage()
	{
		global $c;

		$this->id=$_GET['p'];

		$dmp="SELECT po_id,title,content,link,create_date,modify_date,us_id,CASE WHEN nickname IS NOT NULL THEN nickname ELSE username END as name,
			  p.active as po_active,protect,parent,comments,post_id,post_passwd
		      FROM (cm_posts p INNER JOIN cm_users ON author=us_id) LEFT OUTER JOIN cm_protect ON post_id=po_id
              WHERE po_id=$this->id"; 
		if($d=$c->query($dmp)){
			while($v=$d->fetch_assoc()){
				$this->pt=stripslashes($v['title']);
				$this->pc=stripslashes($v['content']);
				$this->pl=$v['link'];
				$this->pcd=$v['create_date'];
				$this->pmd=$v['modify_date'];
				$this->ui=$v['us_id'];
				$this->un=$v['name'];
				$pa=$v['po_active'];
				$pp=$v['protect'];
				$pr=$v['parent'];
				$cm=$v['comments'];
				$this->ppi=$v['post_id'];
				$this->pps=$v['post_passwd'];

				if($pa == 1) $this->paa="<input type=\"checkbox\" name=\"page_active\" checked />Activate page after publishing<br />";
				else $this->paa="<input type=\"checkbox\" name=\"page_active\" />Activate page after publishing<br />";

				if($cm == 1) $this->pcm="<input type=\"checkbox\" name=\"page_comments\" checked />Allow comments on this page<br />";
				else $this->pcm="<input type=\"checkbox\" name=\"page_comments\" />Allow comments on this page<br />";

				if($pp == 1) $this->ppp="<input type=\"checkbox\" name=\"page_protect\" id=\"post_protect\" checked />Protect this page with password<br />";
				else $this->ppp="<input type=\"checkbox\" name=\"page_protect\" id=\"post_protect\" />Protect this page with password<br />";
			}
		}
		/*else{
			return "<can not grab the page>";
		}*/

	} //else exit(header("Location: index.php"));

	# EDITING THE PAGE
	public function Edit()
	{
		global $c;
		global $options;
		global $tracking;
		global $ss1;
								
		# Page title
		$page_title=addslashes($_POST['page_title']);
		# Page content
		$page_content=addslashes($_POST['page_content']);
		# Page author
		$page_author=$_POST['page_author'];
		# Page category
		$page_parent=$_POST['page_parent'];
		# Page activation
		if(isset($_POST['page_active'])) $page_active=1; else $page_active=0;
		# Page comments
		if(isset($_POST['page_comments'])) $page_comments=1; else $page_comments=0;
		# Page protection
		if(isset($_POST['page_protect'])){ 
			$page_protect=1; 
			$ppt=true; 
		} else{ 
			$page_protect=0; 
			$ppt=false; 
		}
		# Page protection password
		$page_protect_passwd=$ss1->shiftshell(trim($_POST['post_passwd']));
		# Page modify date (same as create date)
		$modify_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
		# Page link (custom or not)
		$page_link=$_POST['page_link'];

		# SQL dumping = cm_post 
		$dmp="UPDATE cm_posts
			SET
				title=\"$page_title\",
				content=\"$page_content\",
				author=$page_author,
				category=0,
				link=\"$page_link\",
				type=1,
				active=$page_active,
				modify_date=$modify_date,
				protect=$page_protect,
				parent=$page_parent,
				comments=$page_comments
			WHERE po_id=$this->id"; 

			if($ppt && $ppp == '0' && $_POST['post_passwd'] == '' && strlen($_POST['post_passwd']) == 0)
			{
				# Redirection to editpost.php
				exit(header("Location: editpage.php?p=$this->id&m=136"));
			}

		if($c->query($dmp)){
			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('page',$page_title,'UPDATE');
			}

			# SQL dumping = cm_protect (post password protection)
			if($ppt){
				// Check if password already exists or not
				/*$dmp="SELECT * FROM cm_protect WHERE post_id=$id";
				$d=mysqli_query($c,$dmp);
				if(mysqli_num_rows($d) == 1 && strlen($_POST['post_protect_passwd'])>0){
					$dmp="UPDATE cm_protect
						  SET post_passwd=\"$post_protect_passwd\"
					  	  WHERE post_id=$id";
					mysqli_query($c,$dmp);
				}
				else if(mysqli_num_rows($d) == 0 && strlen($_POST['post_protect_passwd'])>0){
					$dmp="INSERT INTO cm_protect(post_id,post_passwd)
						  VALUES($id,\"$post_protect_passwd\")";
					mysqli_query($c,$dmp);
				}*/
				if(isset($_POST['post_passwd']) && $_POST['post_passwd']!='' && strlen($_POST['post_passwd'])>0){
					$post_passwd=$ss1->shiftshell(trim($_POST['post_passwd']));

					$dmp="SELECT pr_id FROM cm_protect WHERE post_id=$this->id";
					$d=$c->query($dmp);
					if($d->num_rows == 1){
						$dmp="UPDATE cm_protect
							  SET post_passwd=\"$post_passwd\"
						  	  WHERE post_id=$this->id";
						$c->query($dmp);
					}
					else if($d->num_rows == 0){
						$dmp="INSERT INTO cm_protect(post_id,post_passwd)
							  VALUES($this->id,\"$post_passwd\")";
						$c->query($dmp);
					}
				}
				else if($ppp != '0' && $_POST['post_passwd']=='' && strlen($_POST['post_passwd'])==0){
					$post_passwd=$ppp; 

					$dmp="SELECT pr_id FROM cm_protect WHERE post_id=$this->id";
					$d=$c->query($dmp);
					if($d->num_rows == 1){
						$dmp="UPDATE cm_protect
							  SET post_passwd=\"$post_passwd\"
						  	  WHERE post_id=$this->id";
						$c->query($dmp);
					}
				}
			}
			else{
				$dmp="DELETE FROM cm_protect WHERE post_id=$this->id";
				$c->query($dmp);
				$dmp="UPDATE cm_post
						  SET protect=$post_protect
					  	  WHERE po_id=$this->id";
				$c->query($dmp);
			}


			# Create sitemap
			if($options->sitemap() == 1) 
			{
				require('sitemap.php');
				$sitemap = new Sitemap();
			}

			# Redirection to editpage.php
			exit(header("Location: editpage.php?p=$this->id&m=4"));
			
		}
		else{
			# Redirection to editpage.php
			exit(header("Location: editpage.php?p=$this->id&m=102"));
		}

	}

	# GRAB USERS
	private function GrabUsers(){	
		globaL $c;

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

	# GRAB PARENTS
	private function GrabParents(){	
		global $c;

		$dmp="SELECT po_id,title FROM cm_posts WHERE type=1 AND parent=0";
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}
}

# Try to create EditPage object
try
{
	$editpage = new EditPage();

	if(isset($_POST['edit_page_btn']))
	{
		$editpage->Edit();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>