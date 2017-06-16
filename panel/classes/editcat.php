<?php 

/*
 * This is a class for editing category
 */

class EditCategory
{
	public $id;
	public $cn;
	public $caa;
	public $cva;

	public function __construct()
	{
		$this->CheckPerm();

		if(isset($_GET['c']))
		{
			$this->ViewCategory();
		}
		else
		{
			exit(header("Location: index.php"));
		}
	} 

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->bctr,$permission->bctw,'editcat','&c='.$_GET['c']);
	}

	# GRAB THE POST ID FOR EDITING
	private function ViewCategory()
	{
		global $c;

		$this->id=$_GET['c'];

		$dmp="SELECT cat_name as cn,visible as vi,active as ac
			  FROM cm_category 
			  WHERE ca_id=$this->id";
		if($d=$c->query($dmp)){
			while($v=$d->fetch_assoc()){
				$this->cn=$v['cn'];
				$vi=$v['vi'];
				$ac=$v['ac'];

				if($vi == 1) $this->caa="<input type=\"checkbox\" name=\"cat_active\" checked />Activate this category<br />";
				else $this->caa="<input type=\"checkbox\" name=\"cat_active\" />Activate this category<br />";

				if($ac == 1) $this->cva="<input type=\"checkbox\" name=\"cat_visible\" checked />Set this category visible<br />";
				else $this->cva="<input type=\"checkbox\" name=\"cat_visible\" />Set this category visible<br />";
			}
		}
		else{
			return "<can not grab the category>";
		}

	} 

	# EDITING THE CATEGORY
	public function Edit()
	{
		global $c;
		global $options;
		global $tracking;

		# Category title
		$cat_name=trim($_POST['cat_name']);
		# Category activate
		if(isset($_POST['cat_active'])) $cat_active=1; else $cat_active=0;
		# Category visible
		if(isset($_POST['cat_visible'])) $cat_visible=1; else $cat_visible=0;

		# SQL dumping = cm_post 
		$dmp="UPDATE cm_category
			SET
				cat_name=\"$cat_name\",
				active=$cat_active,
				visible=$cat_visible
			WHERE ca_id=$this->id";
		if($c->query($dmp)){
			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('category',$cat_name,'UPDATE');
			}

			# Redirection to editpost.php
			exit(header("Location: editcat.php?c=$this->id&m=7"));
			
		}
		else{
			# Redirection to editpost.php
			exit(header("Location: editcat.php?c=$this->id&m=109"));
		}

	}
}

# Try to create EditCategory object
try
{
	$editcat = new EditCategory();



	if(isset($_POST['edit_cat_btn']))
	{
		$editcat->Edit();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>