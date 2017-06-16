<?php 

/*
 * This is a class for adding new post
 */

class AddPost
{
	public $gu;
	public $gc;

	public function __construct()
	{
		$this->CheckPerm();
		$this->gu = $this->GrabUsers();
		$this->gc = $this->GrabCategories();
	} 

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->bpsr,$permission->bpsw,'posts','');
	}

	# ADDING NEW POST
	public function NewPost()
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
		# Post protection password
		$post_protect_passwd=$ss1->shiftshell(trim($_POST['post_passwd']));
		# Post creation date
		$create_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
		# Post modify date (same as create date)
		$modify_date=$create_date;
		
		# SQL dumping = cm_post 
		$dmp="INSERT INTO cm_posts(title,content,author,category,type,active,create_date,modify_date,protect,parent,comments)
			VALUES(
				\"$post_title\",
				\"$post_content\",
				$post_author,
				$post_category,
				0,
				$post_active,
				$create_date,
				$modify_date,
				$post_protect,
				NULL,
				$post_comments)";

				if($ppt /*&& $ppp == '0'*/ && $_POST['post_passwd'] == '' && strlen($_POST['post_passwd']) == 0)
				{
					# Redirection to editpost.php
					exit(header("Location: addpost.php?m=136"));
				}


		if($c->query($dmp)){
			$last_id=$c->insert_id;

			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('post',$post_title,'INSERT');
			}

			# Post link (custom or not)
			if(strlen(trim($_POST['post_link'])) < 1){
				$sh=$options->site_host();
				$post_link=$sh."/page.php?a=$last_id";
			}
			else{
				$post_link=$_POST['post_link'];
			}

			# SQL dumping = updating cm_post for post link
			$dmp="UPDATE cm_posts SET link=\"$post_link\" WHERE po_id=$last_id";
			if($c->query($dmp)){
				# SQLI dumping = cm_protect (post password protection)
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

						$dmp="SELECT pr_id FROM cm_protect WHERE post_id=$last_id";
						$d=$c->query($dmp);
						if($d->num_rows == 1){
							$dmp="UPDATE cm_protect
								  SET post_passwd=\"$post_passwd\"
							  	  WHERE post_id=$last_id";
							$c->query($dmp);
						}
						else if($d->num_rows == 0){
							$dmp="INSERT INTO cm_protect(post_id,post_passwd)
								  VALUES($last_id,\"$post_passwd\")";
							$c->query($dmp);
						}
					}
					else if($ppp != '0' && $_POST['post_passwd']=='' && strlen($_POST['post_passwd'])==0){
						$post_passwd=$ppp; 

						$dmp="SELECT pr_id FROM cm_protect WHERE post_id=$last_id";
						$d=$c->query($dmp);
						if($d->num_rows == 1){
							$dmp="UPDATE cm_protect
								  SET post_passwd=\"$post_passwd\"
							  	  WHERE post_id=$last_id";
							$c->query($dmp);
						}
					}
				}
				else{
					$dmp="DELETE FROM cm_protect WHERE post_id=$last_id";
					$c->query($dmp);
					$dmp="UPDATE cm_post
							  SET protect=$post_protect
						  	  WHERE po_id=$last_id";
					$c->query($dmp);
				}

				# Create RSS feed
				if($options->rss() == 1)
				{
					require('rss.php');
					$rss = new RSS();
				}
				
				# Redirection to editpost.php
				exit(header("Location: editpost.php?a=$last_id&m=1"));
			}
			else return false;
		}
		else{
			exit(header("Location: addpost.php?m=101"));
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

# Try to create AddPost object
try
{
	$addpost = new AddPost();

	if(isset($_POST['add_post_btn']))
	{
		$addpost->NewPost();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>