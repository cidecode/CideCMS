<?php 

/*
 * This is a class for deleting selected items
 */
	
class Delete
{
	public $pi;
	public $pt;
	public $type;

	public function __construct()
	{
		if(isset($_GET['d']))
		{
			$this->SelectItem();
		}

		if(isset($_GET['ac']))
		{
			$this->DeleteItem();
		}
	}
	
	# GRAB THE ITEM ID FOR DELETING
	private function SelectItem()
	{
		global $c;

		$id=$_GET['d'];
		$this->type=$_GET['t'];
		$host=$_GET['h'];

		switch($this->type){
			case 'post':
			case 'page':
				$dmp="SELECT po_id as r1,title as r2 FROM cm_posts WHERE po_id=$id";
				break;
			case 'category':
				$dmp="SELECT ca_id as r1,cat_name as r2 FROM cm_category WHERE ca_id=$id";
				break;
			case 'user':
				$dmp="SELECT us_id as r1,username as r2 FROM cm_users WHERE us_id=$id";
				break;
			case 'media':
				$dmp="SELECT me_id as r1,name as r2 FROM cm_media WHERE me_id=$id";
				break;
			case 'role':
				$dmp="SELECT ut_id as r1,status_name as r2 FROM cm_userstatus WHERE ut_id=$id";
				break;
			case 'comment':
				$dmp="SELECT co_id as r1,content as r2 FROM cm_comments WHERE co_id=$id";
				break;
			case 'widget':
				$dmp="SELECT wi_id as r1,title as r2 FROM cm_widgets WHERE wi_id=$id";
				break;
			case 'log':
				$dmp="SELECT tr_id as r1,what as r2 FROM cm_tracking WHERE tr_id=$id";
				break;
			case 'theme':
				$this->pi=$id;
				$this->pt=$this->pi;
				break;
		} 
 		if($this->type != "theme"){
			if($d=$c->query($dmp)){
				while($v=$d->fetch_assoc()){
					$this->pi=$v['r1'];
					$this->pt=$v['r2'];
				}
			}
			else{
				return "<can not grab the $type>";
			}
		}

	} 

	# DELETING THE ITEM 
	private function DeleteItem()
	{
		global $c;
		global $options;
		global $tracking;
		global $constants;

		$id=$_GET['d'];
		$ac=$_GET['ac'];
		$host=$_GET['h']; 

		if($ac == 'delete'){
			# SQL dumping = deleting articles from cm_posts
			switch($this->type){
				case 'post':
					$dmp="DELETE FROM cm_posts WHERE po_id=$id";
					$this->Execute($dmp);
					# User tracking system
					if($options->tracking_system() == 1){	$tracking->logs('page',$this->pt,'DELETE'); }
					break;
				case 'page':
					$dmp="DELETE FROM cm_posts WHERE po_id=$id";
					$this->Execute($dmp);
					# User tracking system
					if($options->tracking_system() == 1){	$tracking->logs('post',$this->pt,'DELETE'); }
					break;
				case 'category':
					$dmp="DELETE FROM cm_category WHERE ca_id=$id";
					$this->Execute($dmp);
					# User tracking system
					if($options->tracking_system() == 1){	$tracking->logs('category',$this->pt,'DELETE'); }
					break;
				case 'user':
					$dmp="DELETE FROM cm_users WHERE us_id=$id";
					$this->Execute($dmp);
					# User tracking system
					if($options->tracking_system() == 1){	$tracking->logs('user',$this->pt,'DELETE'); }
					break;
				case 'media':
					$dmp="DELETE FROM cm_media WHERE me_id=$id";
					$this->Execute($dmp);
					# User tracking system
					if($options->tracking_system() == 1){	$tracking->logs('media',$this->pt,'DELETE'); }
					break;
				case 'role':
					$dmp="DELETE FROM cm_userstatus WHERE ut_id=$id";
					$this->Execute($dmp);
					# User tracking system
					if($options->tracking_system() == 1){	$tracking->logs('role',$this->pt,'DELETE'); }
					break;
				case 'comment':
					$dmp="DELETE FROM cm_comments WHERE co_id=$id";
					$this->Execute($dmp);
					# User tracking system
					if($options->tracking_system() == 1){	$tracking->logs('comment',$this->pt,'DELETE'); }
					break;
				case 'widget':
					$dmp="DELETE FROM cm_widgets WHERE wi_id=$id";
					$this->Execute($dmp);
					# User tracking system
					if($options->tracking_system() == 1){	$tracking->logs('widget',$this->pt,'DELETE'); }
					break;
				case 'log':
					$dmp="DELETE FROM cm_tracking WHERE tr_id=$id";
					$this->Execute($dmp);
					break;
				case 'theme':
					$dir_p=".".$constants::THEME_PATH."/".$id;

					// Check if theme exists
					if(is_dir($dir_p)){
						$this->DeleteDir($dir_p);
						exit(header("Location: themes.php?m=14"));
					}
					else{
						exit(header("Location: themes.php?m=122"));
					}
					
					break;
			}
		}
		else if($ac == 'cancel'){
			exit(header("Location: $host")); 
		}
	}

	private function Execute($dmp)
	{
		global $c;
		global $options;
		global $tracking;

		$host = $_GET['h'];

		if($c->query($dmp)){

			if($options->tracking_system() == 1 && $this->type != 'log')
			{
				$tracking->logs($this->type,$this->pt,'DELETE');
			}
			# Create RSS feed
			if($options->rss() == 1) 
			{
				require('rss.php');
				$rss = new RSS();
			}

			# Create sitemap
			if($options->sitemap() == 1)
			{
				require('sitemap.php');
				$sitemap = new Sitemap();
			}

			exit(header("Location: $host?m=5"));
			
		}
		else{
			exit(header("Location: $host?m=104"));
		}
	}

	private function DeleteDir($dir) {										
		if($od = opendir($dir)) 
		{
			while(false !== ($file = readdir($od))) 
			{
				if(is_dir("{$dir}/{$file}")) 
				{
					if(($file != '.') && ($file != '..'))
					{
						$this->DeleteDir("$dir/$file");
					}
				}
				else
				{
					unlink("{$dir}/{$file}");
				}
			}
			closedir($od);
		}
		rmdir($dir);						
	}
}

# Try to create Delete object
try
{
	$delete = new Delete();

	
}
catch(Exception $e)
{
	die($e->getMessages());
}

?>