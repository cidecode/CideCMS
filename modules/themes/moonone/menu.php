<!-- Navigation bar -->
<div id="nav">
	<ul>
		<li><a href="index.php" name="homepage">Home</a></li>
		<?php if($permission->fpgr == 1) echo $menu->grab_menu(); ?>
	</ul>
</div>