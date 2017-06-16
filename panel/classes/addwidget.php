<?php 

/*
 * This is a class for adding new widget
 */

class AddWidget
{
	public function __construct()
	{
		$this->CheckPerm();
	}

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->bpgr,$permission->bpgw,'widget','');
	}

	# ADDING NEW PAGE
	public function NewWidget()
	{
		global $c;
		global $options;
		global $tracking;

		# Page title
		$widget_title=addslashes($_POST['widget_title']);
		# Page content
		$widget_content=addslashes($_POST['widget_content']);
		# Page activation
		if(isset($_POST['widget_active'])) $widget_active=1; else $widget_active=0;
		# SQL dumping = cm_post 
		$dmp="INSERT INTO cm_widgets(title,content,active)
			VALUES(\"$widget_title\",\"$widget_content\",$widget_active)"; 
		if($c->query($dmp)){
			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('widget',$widget_title,'INSERT');
			}

			$last_id=$c->insert_id;
			$sh=$options->site_host();
			$page_link.=$last_id;
			exit(header("Location: editwidget.php?w=$last_id&m=21"));
			
		}
		else{
			exit(header("Location: addwidget.php?m=133"));
		}

	}
}

# Try to create AddWidget object
try
{
	$addwidget = new AddWidget();

	if(isset($_POST['add_widget_btn']))
	{
		$addwidget->NewWidget();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>