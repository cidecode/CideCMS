<!-- comments body -->
<?php if($options->site_comments() == 1){ ?>
<div id="com-body">
	<?php if($permission->fcmw == 1){ ?>
	<span class="com-title">Write comment</span>
	<div id="wrt-com">
		<form action="<?php echo $host_uri->host_uri(); ?>" method="post">
			<?php if(!$sessions->f_ses){ ?>
			<input type="text" name="com_name" placeholder="Your name..." /><br />
			<input type="text" name="com_email" placeholder="Your email..." /><br />
			<?php } ?>
			<textarea name="com_content" placeholder="Your comment..."></textarea>
			<?php if(!$sessions->f_ses){ ?>
			<p class="com-warning">You are commenting as guest. Please <a href="login.php?hu=<?php echo $options->host_uri(); ?>">log in</a>.<br />If you leave empty "Your name" field the comment is under Anonimous.</p>
			<?php } ?>
			<br /><input type="submit" name="add_com_btn" value="Comment" />	
		</form>
	</div>
	<?php } 
		if(isset($_GET['seco'])){
			if($_GET['seco']) echo "You successfuly added comment.";
		}
	?>
	
	<div id="coms">		
		<?php if($permission->fcmr == 1){ if($comments->ac){ ?>
		<span class="com-title">Comments (<?php echo $comments->grab_com_number(); ?>)</span>
		<?php while($v=$comments->ac->fetch_assoc()): ?>
			<div class="art-com">
				<p class="com-info">
					<span class="usrname"><?php echo $v['fn']; ?></span> 
					- date: <?php echo date("d.m.Y",$v['cd']); ?>
				</p>
				<p class="art-usr-com"><?php echo $v['ct']; ?></p>
			</div>
		<?php endwhile; } else { ?>
		<span class="com-title">No comments <?php echo $comments->ac; ?></span>
		<?php }} ?>
	</div>
</div>
<?php } ?>