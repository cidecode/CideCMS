<?php 

# PERMISSION CHECK UP
/*if($finr == 0){
	exit(header("Location: index.php"));
}*/

# POST VIEWING
if(isset($_GET['pp']) && $_GET['pp'] != '' && isset($_GET['pi']) && $_GET['pi'] > 0){
	$pp=$_GET['pp'];
	$id=$_GET['pi'];

	# SQL dumping 
	$dmp="SELECT title as tt, link as ln FROM cm_posts WHERE po_id=$id";

	if($d=$c->query($dmp)){
		while($v=$d->fetch_assoc()):
			$tt=$v['tt'];
			$ln=$v['ln'];			
		endwhile;

		$d->free_result();

	}

}
else{
	exit(header("Location: index.php"));
}




?>