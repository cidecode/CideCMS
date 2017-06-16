<?php 

/*
 * This class will display comments on 
 * post or page if they exists.
 */

class Comments
{
	public $ac;
	private $id;

	public function __construct($postid)
	{
		$this->id = $postid;
		$this->ac = $this->all_comments();
	}

	public function grab_com_number(){
		global $c;
		global $id;

		$dmp="SELECT COUNT(co_id) as conm FROM cm_comments WHERE post_id=$this->id AND active=1";
		if($d=$c->query($dmp)){
			$r=$d->fetch_assoc();
			return $r['conm'];
		}
	}

	# Grab articles
	public function all_comments(){
		global $c;
		
		$dmp="SELECT co_id as ci,c.content as ct,c.full_name as fn,email as em,c.create_date as cd,user_id as ui,post_id as pi, 
				  c.active as ac,nickname as nk,title as tl,username as un,link as ln,(SELECT COUNT(co_id) FROM cm_comments WHERE post_id=$this->id AND c.active=1) as conm
				  FROM (cm_comments as c LEFT OUTER JOIN cm_posts as p ON c.post_id=p.po_id) LEFT OUTER JOIN cm_users as u ON c.user_id=u.us_id
				  WHERE post_id=$this->id AND c.active=1
				  ORDER BY c.create_date DESC"; 
		
		if($d=$c->query($dmp)){
			return $d;
		}
		else
		{
			$sn="<can't grab articles>";
			return false;
		}
	}
	
	# Add comment
	public function AddComment($com_name,$com_email,$com_content)
	{
		global $c;
		global $sessions;
		global $sessions;
		global $host_uri;

		if($com_name != null && $com_email != null){
			$name=trim($com_name);
			$author="anonymous";
			$email=trim($com_email);
			$user_id=0;
		}
		else{
			$dmp="SELECT us_id,nickname,user_email FROM cm_users WHERE username=\"$sessions->s_username\""; 
			$d=$c->query($dmp);
			$r=$d->fetch_assoc();
			$name=$r['nickname'];
			$author=$sessions->s_user_id;
			$email=$r['user_email'];
			$user_id=$r['us_id'];
		}
		$content=trim($com_content);
		$create_date=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

		// SQL dumping
		$dmp="INSERT INTO cm_comments VALUES('',\"$name\",\"$content\",\"$email\",$user_id,$this->id,$create_date,0)";
		if($c->query($dmp)){
			exit(header("Location: ".$host_uri->host_uri()."&seco=true"));			
		}
	}
	
}
# Try to create Comments object
try
{
	$comments = new Comments($_GET['a']);
}
catch(Exception $e)
{
	die($e->getMessage());
}


# ADD COMMENT
if(isset($_POST['add_com_btn']))
{
	if(isset($com_name) && strlen(trim($com_name))>0 && isset($com_email) && strlen(trim($com_email))>0)
	{
		$comments->AddComment($_POST['com_name'],$_POST['com_email'],$_POST['com_content']);
	}
	else
	{
		$comments->AddComment(null,null,$_POST['com_content']);
	}
}

?>