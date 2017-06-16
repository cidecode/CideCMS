<?php 

/*
 * This is a class that will display selected 
 * post for editing.
 */

class EditPost
{
	public $id;
	public $pt;
	public $pc;
	public $pl;
	public $pcd;
	public $pmd;
	public $ui;
	public $un;
	public $ci;
	public $cn;
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
		$this->gc = $this->GrabCategories();

		if(isset($_GET['a']))
		{
			$this->ViewPost();
		}
		else
		{
			exit(header("Location: index.php"));
		}
	} 

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->bpsr,$permission->bpsw,'editpost','&a='.$_GET['a']);
	}


	# GRAB THE POST ID FOR EDITING
	private function ViewPost()
	{
		global $c;

		$this->id=$_GET['a'];

		$dmp="SELECT po_id,title,content,link,create_date,modify_date,us_id,CASE WHEN nickname IS NOT NULL  THEN nickname ELSE username END as name,
			  p.active as po_active,protect,ca_id,cat_name,comments,post_id,post_passwd
		      FROM (cm_posts p INNER JOIN cm_users ON author=us_id) INNER JOIN cm_category ON category=ca_id LEFT OUTER JOIN cm_protect ON post_id=po_id
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
				$this->ci=$v['ca_id'];
				$this->cn=$v['cat_name'];
				$cm=$v['comments'];
				$this->ppi=$v['post_id'];
				$this->pps=$v['post_passwd'];

				if($pa == 1) $this->paa="<input type=\"checkbox\" name=\"post_active\" checked />Activate post after publishing<br />";
				else $paa="<input type=\"checkbox\" name=\"post_active\" />Activate post after publishing<br />";

				if($cm == 1) $this->pcm="<input type=\"checkbox\" name=\"post_comments\" checked />Allow comments on this post<br />";
				else $pcm="<input type=\"checkbox\" name=\"post_comments\" />Allow comments on this post<br />";

				if($pp == 1) $this->ppp="<input type=\"checkbox\" name=\"post_protect\" id=\"post_protect\" checked />Protect this post with password<br />";
				else $this->ppp="<input type=\"checkbox\" name=\"post_protect\" id=\"post_protect\" />Protect this post with password<br />";
			}
		}
		else{
			return "<can not grab the post>";
		}

	} 

	# EDITING THE POST
	public function Edit()
	{
		global $c;
		global $options;
		global $tracking;
		global $ss1;

		# Post title
		$post_title=addslashes($_POST['post_title']);
		# Post content
		$post_content=addslashes($_POST['post_content']);
		# Post author
		$post_author=$_POST['post_author'];
		# Post category
		$post_category=$_POST['post_category'];
		# Post activation
		if(isset($_POST['post_active'])) $post_active=1; else $post_active=0;
		# Post comments
		if(isset($_POST['post_comments'])) $post_comments=1; else $post_comments=0;
		# Post protection
		if(isset($_POST['post_protect'])){ 
			$post_protect=1; 
			$ppt=true; 
		} else{ 
			$post_protect=0; 
			$ppt=false; 
		}
		# Post modify date (same as create date)
		$modify_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
		# Post link (custom or not)
		$post_link=$_POST['post_link'];

		# SQL dumping = cm_post 
		$dmp="UPDATE cm_posts
			SET
				title=\"$post_title\",
				content=\"$post_content\",
				author=$post_author,
				category=$post_category,
				link=\"$post_link\",
				type=0,
				active=$post_active,
				modify_date=$modify_date,
				protect=$post_protect,
				parent=0,
				comments=$post_comments
			WHERE po_id=$this->id"; 

		if($ppt && $this->pps == '0' && $_POST['post_passwd'] == '' && strlen($_POST['post_passwd']) == 0)
		{
			# Redirection to editpost.php
			exit(header("Location: editpost.php?a=$this->id&m=136"));
		}	

		if($c->query($dmp)){
			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('post',$post_title,'UPDATE');
			}

			# SQL dumping = cm_protect (post password protection)
			if($ppt){
				// Check if password already exists or not
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
				else if($pps != '0' && $_POST['post_passwd']=='' && strlen($_POST['post_passwd'])==0){
					$post_passwd=$pps; 

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

			# Create RSS feed
			if($options->rss() == 1)
			{
				require('rss.php');
				$rss = new RSS();
			}

			# Redirection to editpost.php
			exit(header("Location: editpost.php?a=$this->id&m=2"));
			
		}
		else{
			# Redirection to editpost.php
			exit(header("Location: editpost.php?a=$this->id&m=100"));
		}

	}

	# Delete password on post
	public function DeletePostPasswd()
	{
		global $c;

		$dmp="UPDATE cm_posts SET protectpass=0,protect=0 WHERE po_id=$this->id";
		if($c->query($dmp)){
			# Redirection to editpost.php
			exit(header("Location: editpost.php?a=$this->id&m=23"));
		}
		else{
			# Redirection to editpost.php
			exit(header("Location: editpost.php?a=$this->id&m=135"));
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

	# GRAB CATEGORIES
	private function GrabCategories(){	
		global $c;

		$dmp="SELECT ca_id,cat_name
			  FROM cm_category";
		if($d=$c->query($dmp))
			return $d;
		else 
			return false;
		
		$d->free_result();
	}
}

# Try to create EditPost object
try
{
	$editpost = new EditPost();

	if(isset($_POST['edit_post_btn']))
	{
		$editpost->Edit();
	}

	if(isset($_GET['ppd']) && $_GET['ppd'] == true)
	{
		$editpost->DeletePostPasswd();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>