<?php 

/*
 * This is a class for adding new category
 */

class AddCategory
{
	public function __construct()
	{
		$this->CheckPerm();
	}

	private function CheckPerm()
	{
		global $permission;

		if($permission->bctr == 0 && $permission->bctw == 0){
			exit(header("Location: index.php"));
		}
	}

	# ADDING NEW CATEGORY
	public function NewCategory()
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
		$dmp="INSERT INTO cm_category(cat_name,active,visible)
			VALUES(
				\"$cat_name\",
				$cat_active,
				$cat_visible)";
		if($c->query($dmp)){
			$last_id=$c->insert_id;

			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('category',$cat_name,'INSERT');
			}

			exit(header("Location: editcat.php?c=$last_id&m=8"));
		}
		else{
			exit(header("Location: editcat.php?m=110"));
		}

	}
}

# Try to create AddCategory object
try
{
	$addcat = new AddCategory();

	if(isset($_POST['add_cat_btn']))
	{
		$addcat->NewCategory();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>