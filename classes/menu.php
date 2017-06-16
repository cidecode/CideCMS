<?php 

/*
 * This is class that will grab menu items 
 * from database.
 */

class Menu
{
	private $menuItems;

	# Grab the navigation items
	public function __construct(){
		global $c;
		$this->menuItems="";
		$dmp="SELECT po_id as pi,link as ln_p,title as tt_p FROM cm_posts WHERE type=1 AND active=1 AND parent=0";
		if($d=$c->query($dmp)){
			while($r=$d->fetch_array(MYSQLI_ASSOC)){
				$this->menuItems.="<li><a href=\"".$r['ln_p']."\" name=\"id\">".$r['tt_p']."</a>";

				// Check if item is parent
				$dmp="SELECT link as ln_c,title as tt_c FROM cm_posts WHERE type=1 AND active=1 AND parent=".$r['pi']; 
				if($p=$c->query($dmp)){
					if($p->num_rows > 0){
						$this->menuItems.="<ul class=\"sub-menu\">";
						while($o=$p->fetch_array(MYSQLI_ASSOC)){
							$this->menuItems.="<li><a href=\"".$o['ln_c']."\" name=\"id\">".$o['tt_c']."</a>";
						}
						$this->menuItems.="</ul>";
					}
				}

				$this->menuItems.="</li>";
			}
		}
		mysqli_free_result($d);
	}

	public function grab_menu()
	{
		return $this->menuItems;
	}
}	

# Try to create Menu object
try
{
	$menu = new Menu();
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>