<!-- Navigation bar -->
<div id="nav">
	<span>Manage your site</span>
	<ul>
	<?php
		if($permission->bcpr == 1 || $permission->bcpw == 1)
			echo "<a href=\"index.php\"><li>Control panel</li></a>";
		if($permission->bpgr == 1 || $permission->bpgw == 1)
			echo "<a href=\"pages.php\"><li>Pages</li></a>";
		if($permission->bpsr == 1 || $permission->bpsw == 1)
			echo "<a href=\"posts.php\"><li>Posts</li></a>";
		if($permission->bcmr == 1 || $permission->bcmw == 1)
			echo "<a href=\"comments.php\"><li>Comments</li></a>";
		if($permission->bmdr == 1 || $permission->bmdw == 1)
			echo "<a href=\"media.php\"><li>Media</li></a>";
		if($permission->busr == 1 || $permission->busw == 1)
			echo "<a href=\"users.php\"><li>Users</li></a>";
		if($permission->bpgr == 1 || $permission->bpgw == 1)
			echo "<a href=\"widgets.php\"><li>Widgets</li></a>";
		if($permission->brlr == 1 || $permission->brlw == 1)
			echo "<a href=\"roles.php\"><li>Roles</li></a>";
		if($permission->bthr == 1 || $permission->bthw == 1)
			echo "<a href=\"themes.php\"><li>Themes</li></a>";
		if($permission->bpur == 1 || $permission->bpuw == 1)
			echo "<a href=\"plugins.php\"><li>Plugins</li></a>";
		if($permission->botr == 1 || $permission->botw == 1)
			echo "<a href=\"options.php\"><li>Options</li></a>";
		echo "<a href=\"".$options->site_host()."\" target=\"_blank\"><li>Visit site</li></a>";

	?>
	</ul>
</div>