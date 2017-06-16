<?php 

/*
 * This is a class for adding new page
 */

class AddPage
{
	public $gu;
	public $gp;

	public function __construct()
	{
		$this->CheckPerm();
		$this->gu = $this->GrabUsers();
		$this->gp = $this->GrabParents();
	} 

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->bpgr,$permission->bpgw,'pages','');
	}

	
	# ADDING NEW PAGE
	public function NewPage()
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
		# Page creation date
		$create_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
		# Page modify date (same as create date)
		$modify_date=$create_date;
		# Page link (custom or not)
		if(strlen(trim($_POST['page_link'])) < 1){
			$sh=$options->site_host();
			$page_link=$sh."/page.php?p=";
		}
		else $page_link=$_POST['page_link'];

		# SQL dumping = cm_post 
		$dmp="INSERT INTO cm_posts(title,content,author,category,type,active,create_date,modify_date,protect,parent,comments)
			VALUES(
				\"$page_title\",
				\"$page_content\",
				$page_author,
				0,
				1,
				$page_active,
				$create_date,
				$modify_date,
				$page_protect,
				$page_parent,
				$page_comments)"; 

				if($ppt && $ppp == '0' && $_POST['post_passwd'] == '' && strlen($_POST['post_passwd']) == 0)
				{
					# Redirection to editpost.php
					exit(header("Location: addpage.php?m=136"));
				}

		if($c->query($dmp)){
			$last_id=$c->insert_id;
			$sh=$options->site_host();
			$page_link.=$last_id;

			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('page',$upage_title,'INSERT');
			}

			# SQL dumping = updating cm_post for post link
			$dmp="UPDATE cm_posts SET link=\"$page_link\" WHERE po_id=$last_id";
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

				# Create sitemap
				if($options->sitemap() == 1) 
				{
					require('sitemap.php');
					$sitemap = new Sitemap();
				}


				# Redirection to editpost.php
				exit(header("Location: editpage.php?p=$last_id&m=3")); 
				#echo "editpage.php?p=$last_id&m=3";
			}
			else return false;
		}
		else{
			exit(header("Location: addpage.php?m=103"));
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

# Try to create AddPage object
try
{
	$addpage = new AddPage();

	if(isset($_POST['add_page_btn']))
	{
		$addpage->NewPage();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>