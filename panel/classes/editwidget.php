<?php 

/*
 * This is a class for editing widget
 */

class EditWidget
{
	public $id;
	public $tt;
	public $ct;
	public $paa;
	public $cva;

	public function __construct()
	{
		$this->CheckPerm();

		if(isset($_GET['w']))
		{
			$this->ViewWidget();
		}
		else
		{
			exit(header("Location: index.php"));
		}
	} 

	private function CheckPerm()
	{
		global $permission;

		$permission->perm_check_up($permission->bpgr,$permission->bpgw,'editwidget','&w='.$_GET['w']);
	}

	# GRAB THE PAGE ID FOR EDITING
	private function ViewWidget()
	{
		global $c;

		$this->id=$_GET['w'];

		$dmp="SELECT title as tt,content as ct,active as ac
			  FROM cm_widgets
              WHERE wi_id=$this->id"; 
		if($d=$c->query($dmp)){
			while($v=$d->fetch_assoc()){
				$this->tt=stripslashes($v['tt']);
				$this->ct=stripslashes($v['ct']);
				$ac=$v['ac'];

				if($ac == 1) $this->paa="<input type=\"checkbox\" name=\"widget_active\" checked />Activate this widget<br />";
				else $this->paa="<input type=\"checkbox\" name=\"widget_active\" />Activate this widget<br />";
			}
		}
		else{
			return "<can not grab the widget>";
		}

	} 

	# EDITING THE PAGE
	public function Edit()
	{
		global $c;
		global $options;
		global $tracking;

		# Widget title
		$widget_title=addslashes($_POST['widget_title']);
		# Widget content
		$widget_content=addslashes($_POST['widget_content']);
		# Widget activation
		if(isset($_POST['widget_active'])) $widget_active=1; else $widget_active=0;

		# SQL dumping = cm_post 
		$dmp="UPDATE cm_widgets
			SET
				title=\"$widget_title\",
				content=\"$widget_content\",
				active=$widget_active
			WHERE wi_id=$this->id"; 
		if($c->query($dmp)){
			# User tracking system
			if($options->tracking_system() == 1){
				$tracking->logs('widget',$widget_title,'UPDATE');
			}

			# Redirection to editpage.php
			exit(header("Location: editwidget.php?w=$this->id&m=20"));
			
		}
		else{
			# Redirection to editpage.php
			exit(header("Location: editwidget.php?w=$this->id&m=132"));
		}

	}
}

# Try to create EditWidget object
try
{
	$editwidget = new EditWidget();

	if(isset($_POST['edit_widget_btn']))
	{
		$editwidget->Edit();
	}
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>