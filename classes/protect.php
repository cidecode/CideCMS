<?php

/*
 * This is a class that will protect your posts/pages
 */

class Protect 
{
	public $post_protection_confirmed;
	public $tt;
	public $ln;
	public $pp;
	public $pr;


	public function __construct()
	{
		global $host_uri;
		global $pview;
		global $c; die("ddd");

		$this->post_protection_confirmed = false;

		if($this->post_protection_confirmed) 
		{
			$this->pr = 0; 
		}

		if($pview->pr == 1){  
			exit(header("Location: post_protect.php?pp=".$host_uri->host_uri().'&pi='.$pview->id));
		}

		$this->ViewWhatsProtected();

	}

	public function ViewWhatsProtected()
	{
		global $c;

		if(isset($_GET['pp']) && $_GET['pp'] != '' && isset($_GET['pi']) && $_GET['pi'] > 0){
			$this->pp=$_GET['pp'];
			$id=$_GET['pi'];

			# SQL dumping 
			$dmp="SELECT title as tt, link as ln FROM cm_posts WHERE po_id=$id"; 

			if($d=$c->query($dmp)){
				while($v=$d->fetch_assoc()):
					$this->tt=$v['tt'];
					$this->ln=$v['ln'];			
				endwhile;

				$d->free_result();

			}

		}
		else{ 
			exit(header("Location: index.php"));
		}
	}

	public function ConfirmPasswd()
	{
		global $c;
		global $ss1;
		global $host_uri;
		global $pview;

		$pass_confirm=$ss1->shiftshell(trim($_POST['ps_protect']));
	
		$dmp="SELECT post_passwd FROM cm_protect WHERE post_id=$pview->id";
		$d=$c->query($dmp);
		while($v=$d->fetch_assoc()):
			$postpasswdtoequal=$v['post_passwd'];		
		endwhile;

		$d->free_result();

		if($postpasswdtoequal == $pass_confirm) 
		{
			$this->post_protection_confirmed=true; 
		}
		else{
			$this->post_protection_confirmed=false; 
			exit(header("Location: post_protect.php?pp=".$host_uri->host_uri()."&pi=".$pview->id."&m=146"));
		} 
	}
}

# Try to create Protect object
try
{ 
	$protect = new Protect();

	if(isset($_POST['protect_confirm_btn']) && isset($_POST['ps_protect']) && strlen($_POST['ps_protect']) > 0)
	{
		$protect->ConfirmPasswd();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>