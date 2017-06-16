<?php 


$post_protection_confirmed=false;

if(isset($_POST['protect_confirm_btn']) && isset($_POST['ps_protect']) && strlen($_POST['ps_protect']) > 0)
{
	$pass_confirm=$ss1->shiftshell(trim($_POST['ps_protect']));
	
	$dmp="SELECT post_passwd FROM cm_protect WHERE post_id=$pview->id";
	$d=$c->query($dmp);
	while($v=$d->fetch_assoc()):
		$postpasswdtoequal=$v['post_passwd'];		
	endwhile;

	$d->free_result();

	if($postpasswdtoequal == $pass_confirm) 
	{
		$post_protection_confirmed=true; 
	}
	else{
		$post_protection_confirmed=false; 
		exit(header("Location: post_protect.php?pp=".$host_uri->host_uri()."&pi=".$pview->id."&m=146"));
	} 
}

if($post_protection_confirmed) 
{
	$pview->pr = 0;
}

if($pview->pr == 1){
	exit(header("Location: post_protect.php?pp=".$host_uri->host_uri().'&pi='.$pview->id));
}

?>