<?php 

/*
 * This class is used to create pagination.
 */

class Pagination
{
	public $st;
	public $apg;

	public function CalculatePagination($pca)
	{
		//global $pca;
		global $c;
		global $options;
		global $constants;

		if(isset($_GET['l']) && isset($_GET['cp']) && isset($_GET['t'])){
			$this->st=$_GET['l'];
			$cp=$_GET['cp'];
			$ty=$_GET['t'];
		}
		else{
			$this->st=0;
			$cp=1;
			$tty=explode('/',$_SERVER['REQUEST_URI']);
			$ttyc=count($tty)-1;
			$ty=explode('.',$tty[$ttyc])[0]; 
			if($ty == ""){
				$ty="index";
			}
		}

		if(isset($_GET['c'])){
			$id="&c=".$_GET['c'];
		}
		else if(isset($_GET['u'])){
			$id="&u=".$_GET['u'];
		} 
		else if(isset($_GET['quest'])) 
		{
			$id="&quest=".$_GET['quest'];
		}
		else{
			$id="";
		}
		if($options->ContentCheck('panel'))
		{
			$this->apg=$constants::ITEMS_PER_PAGE;
		}
		else
		{
			$this->apg=$options->art_per_page();
		}
		$fr=0; // First count
		$lf=$this->st-$this->apg; // Left count
		$rg=$this->st+$this->apg; // Right count
		$ls=floor($pca/$this->apg)*$this->apg; // Last count
		$pp=$cp-1; // Previous page
		$np=$cp+1; // Next page

		$nop=ceil($pca/$this->apg); // Number of pages
		$cpp=ceil($this->st/$this->apg); // Curent page
		$ps="";
		$pcnt=0;
		for($i=1; $i<=$nop; $i++){
			if($i == $cp){
				$path="$ty.php?l=$pcnt&cp=$i&t=$ty".$id;
				$ps.="<li><a href=\"$path\" class=\"pn-current\">$i</a></li>";
			}
			else{
				$path="$ty.php?l=$pcnt&cp=$i&t=$ty".$id;
				$ps.="<li><a href=\"$path\">$i</a></li>";
			}

			$pcnt+=$this->apg;

		}
		$pagwr="<ul>";
		if($this->st > 0){ 
			$path_fr="$ty.php?l=$fr&cp=1&t=$ty".$id;
			$path_lf="$ty.php?l=$lf&cp=$pp&t=$ty".$id;
			$pagwr.="<li><a href=\"$path_fr\"><<</a></li>
			      <li><a href=\"$path_lf\"><</a></li>";
		}							
			$pagwr.=$ps; 
		if($rg < $pca){
			$path_rg="$ty.php?l=$rg&cp=$np&t=$ty".$id;
			$path_ls="$ty.php?l=$ls&cp=$nop&t=$ty".$id;
			$pagwr.="<li><a href=\"$path_rg\">></a></li>
				  <li><a href=\"$path_ls\">>></a></li>";
		}
		$pagwr.="</ul>";

		return $pagwr;
	}
}


?>