<!-- sidebar -->
<div id="sidebar">
	<?php while($v=mysqli_fetch_assoc($widgets->aw)): ?>
	<div class="sb-block">
		<div class="sb-tit-box">
			<span class="sb-title"><?php echo $v['tt']; ?></span>
		</div>
		<?php echo $v['ct']; ?>
	</div>
	<?php endwhile; ?>
</div>