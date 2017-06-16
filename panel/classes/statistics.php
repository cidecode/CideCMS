<?php 

/*
 * This is a class for displaying statistics
 */

class Statistics 
{
	public function __construct()
	{
		$this->CheckPerm();
	}

	private function CheckPerm()
	{
		global $permission;
		global $options;

		if($permission->bcpr == 0){
			exit(header("Location: ".$options->site_host()));
		}
	}

	public function GrabStatistics($what)
	{
		switch($what)
		{
			/*
             * PAGES
			 */
			# Number of all pages
			case "pagecountall": return $this->GrabNum("SELECT COUNT(*) FROM cm_posts WHERE type=1"); break;
			# Number of published pages
			case "pagecountnonpublished": return $this->GrabNum("SELECT COUNT(*) FROM cm_posts WHERE type=1 AND active=0"); break;
			# Number of published pages
			case "pagecountpublished": return $this->GrabNum("SELECT COUNT(*) FROM cm_posts WHERE type=1 AND active=1"); break;
			# Last page title created
			case "lastpagecreatedtitle": return $this->GrabContent("SELECT title FROM cm_posts WHERE type=1 ORDER BY po_id DESC LIMIT 1","title"); break;
			# Last page id created
			case "lastpagecreatedid": return $this->GrabContent("SELECT po_id FROM cm_posts WHERE type=1 ORDER BY po_id DESC LIMIT 1","po_id"); break;
			# Last page date created
			case "lastpagecreatedate": return $this->GrabContent("SELECT create_date FROM cm_posts WHERE type=1 ORDER BY po_id DESC LIMIT 1","create_date"); break;
			# Last page title modify
			case "lastpagemodifytitle": return $this->GrabContent("SELECT title FROM cm_posts WHERE type=1 ORDER BY modify_date DESC LIMIT 1","title"); break;
			# Last page id modify
			case "lastpagemodifyid": return $this->GrabContent("SELECT po_id FROM cm_posts WHERE type=1 ORDER BY modify_date DESC LIMIT 1","po_id"); break;
			# Last page date modify
			case "lastpagemodifydate": return $this->GrabContent("SELECT modify_date FROM cm_posts WHERE type=1 ORDER BY po_id DESC LIMIT 1","modify_date"); break;
			/*
             * POSTS
			 */
			# Number of all posts
			case "postcountall": return $this->GrabNum("SELECT COUNT(*) FROM cm_posts WHERE type=0"); break;
			# Number of non-published posts
			case "postcountnonpublished": return $this->GrabNum("SELECT COUNT(*) FROM cm_posts WHERE type=0 AND active=0"); break;
			# Number of published posts
			case "postcountpublished": return $this->GrabNum("SELECT COUNT(*) FROM cm_posts WHERE type=0 AND active=1"); break;
			# Last post title created
			case "lastpostcreatedtitle": return $this->GrabContent("SELECT title FROM cm_posts WHERE type=0 ORDER BY po_id DESC LIMIT 1","title"); break;
			# Last post id created
			case "lastpostcreatedid": return $this->GrabContent("SELECT po_id FROM cm_posts WHERE type=0 ORDER BY po_id DESC LIMIT 1","po_id"); break;
			# Last post date created
			case "lastpostcreatedate": return $this->GrabContent("SELECT create_date FROM cm_posts WHERE type=0 ORDER BY po_id DESC LIMIT 1","create_date"); break;
			# Last post title modify
			case "lastpostmodifytitle": return $this->GrabContent("SELECT title FROM cm_posts WHERE type=0 ORDER BY modify_date DESC LIMIT 1","title"); break;
			# Last post id modify
			case "lastpostmodifyid": return $this->GrabContent("SELECT po_id FROM cm_posts WHERE type=0 ORDER BY modify_date DESC LIMIT 1","po_id"); break;
			# Last post date modify
			case "lastpostmodifydate": return $this->GrabContent("SELECT modify_date FROM cm_posts WHERE type=0 ORDER BY po_id DESC LIMIT 1","modify_date"); break;

			/*
             * USERS
			 */
			# Number of all users
			case "usercountall": return $this->GrabNum("SELECT COUNT(*) FROM cm_users"); break;
			# Number of non-verified users
			case "usercountnonverified": return $this->GrabNum("SELECT COUNT(*) FROM cm_users WHERE active=0"); break;
			# Number of verified users
			case "usercountverified": return $this->GrabNum("SELECT COUNT(*) FROM cm_users WHERE active=1"); break;
			# Last user name registered
			case "lastuserregisteredusername": return $this->GrabContent("SELECT username FROM cm_users ORDER BY us_id DESC LIMIT 1","username"); break;
			# Last user id registered
			case "lastuserregisteredid": return $this->GrabContent("SELECT us_id FROM cm_users ORDER BY us_id DESC LIMIT 1","us_id"); break;
			# Last user date registered
			case "lastuserregisteredjoindate": return $this->GrabContent("SELECT join_date FROM cm_users ORDER BY us_id DESC LIMIT 1","join_date"); break;
			# Number of administrators
			case "usercountadministrators": return $this->GrabNum("SELECT COUNT(*) FROM cm_users WHERE type=1"); break;
			# Number of moderators
			case "usercountmoderators": return $this->GrabNum("SELECT COUNT(*) FROM cm_users WHERE type=2"); break;
			# Number of authors
			case "usercountauthors": return $this->GrabNum("SELECT COUNT(*) FROM cm_users WHERE type=3"); break;
			# Number of regular users
			case "usercountregularusers": return $this->GrabNum("SELECT COUNT(*) FROM cm_users WHERE type=4"); break;
			# Number of visitors
			case "usercountvisitors": return $this->GrabNum("SELECT COUNT(*) FROM cm_users WHERE type=6"); break;

			/*
             * COMMENTS
			 */
			# Number of all comments
			case "commentcountall": return $this->GrabNum("SELECT COUNT(*) FROM cm_comments"); break;
			# Number of non-approved comments
			case "commentcountnonapproved": return $this->GrabNum("SELECT COUNT(*) FROM cm_comments WHERE active=0"); break;
			# Number of approved comments
			case "commentcountapproved": return $this->GrabNum("SELECT COUNT(*) FROM cm_comments WHERE active=1"); break;
			# Last comment content created
			case "lastcommentcreatedcontent": return $this->GrabContent("SELECT content FROM cm_comments ORDER BY co_id DESC LIMIT 1","content"); break;
			# Last comment date created
			case "lastcommentcreatedate": return $this->GrabContent("SELECT create_date FROM cm_comments ORDER BY co_id DESC LIMIT 1","create_date"); break;


			#case "": return $this->GrabNum(""); break;
			#case "": return $this->GrabContent("",""); break;

		}
	}

	private function GrabNum($dmp)
	{
		global $c;

		if($d=$c->query($dmp)){
			while($v=$d->fetch_row()):
				$num=$v[0];
			endwhile;
		}

		return $num;
	}

	private function GrabContent($dmp,$what)
	{
		global $c;

		if($d=$c->query($dmp)){
			if($d->num_rows == 0)
			{
				$content = "None";
			}

			while($v=$d->fetch_assoc()):
				if($what == "create_date" || $what == "modify_date" || $what == "join_date")
				{
					$content=date("d.m.Y",$v[$what]);
				}
				else
				{
					$content=$v[$what];
				}
			endwhile;
		}

		return $content;
	}
}

# Try to create Statistics object
try
{
	$statistics = new Statistics();
}
catch(Exception $e)
{
	die($e->getMessage());
}


?>