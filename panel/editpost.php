<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/editpost.php');
?>

<!-- HTML TEMPLATE -->
<!-- body page -->
	<body>
		<script type="text/javascript">
		$(document).ready(function(){
			// Post password protection
			if($('#post_protect').attr("checked")) $('#post_protect_password').show();
			else $('#post_protect_password').hide();
			
			$('#post_protect').click(function(){
				if(this.checked)
					$('#post_protect_password').show();
				else
					$('#post_protect_password').hide();
			});

			// Message system 
			<?php $messages->ShowMsg(); ?>

		});
		</script>
		<?php include('editor.php'); ?>
		<!-- Whole page style -->
		<div id="body">
			<!-- Template style -->
			<div id="main">
				<!-- Header style -->
				<?php require('header.php'); ?>
				<!-- Main whole content style (articles and sidebar) -->
				<div id="wrap">
					<?php require('menu.php'); ?>
					<div id="center">
						<!-- THE THING -->
						<div id="content">
							<div id="message-s"></div>
							<div id="message-f"></div>
							<form action="<?php echo $constants->cwd.'?a='.$editpost->id; ?>" method="post" id="add-post">
							<div class="art-title">Edit post
							<input type="submit" class="btn-submit" name="edit_post_btn" <?php $permission->perm_btn_disable($permission->bpsw); ?> value="Update" />
							<a href="posts.php" class="top-btn-link">Back to posts</a></div>
							<div class="article-block">
								
									<h3>Title</h3>
									<input type="text" name="post_title" class="post-title" value="<?php echo $editpost->pt; ?>" /><br />
									<h3>Content</h3>
									<textarea name="post_content" id="post-content"><?php echo $editpost->pc; ?></textarea><br />
									<h3>Post link</h3>
									<input type="text" name="post_link" id="post-link" value="<?php echo $editpost->pl; ?>" /><br />
									<span class="info">(You can customize custom link)</span>
									<h3>Author</h3>
									<select name="post_author">
									<?php while($v=$editpost->gu->fetch_assoc()){ 
										if($v['us_id'] == $editpost->ui)
											echo "<option value=\"".$v['us_id']."\" selected>".$v['name']."</option>";
										else
											echo "<option value=\"".$v['us_id']."\">".$v['name']."</option>";
									} ?>
									</select><br />
									<h3>Category</h3>
									<select name="post_category">
									<?php while($v=$editpost->gc->fetch_assoc()){
										if($v['ca_id'] == $editpost->ci)
											echo "<option value=\"".$v['ca_id']."\" selected>".$v['cat_name']."</option>";
										else
											echo "<option value=\"".$v['ca_id']."\">".$v['cat_name']."</option>";
									} ?>
									</select><br />
									<h3>Post activation</h3>
									<?php echo $editpost->paa; ?>
									<h3>Post comments</h3>
									<?php echo $editpost->pcm; ?>
									<h3>Post protection</h3>
									<?php echo $editpost->ppp; ?>
									<span class="info">(If you are moderating this post/page or it is a secret for public you can put password on it that only you now.)</span>
									<div id="post_protect_password"><h3>Enter post protection password: </h3><br />
									<input type="text" name="post_passwd" id="post-link" />
									<!--<a href="<?php #echo $cwd.'?a='.$id.'&ppd=true'; ?>">Delete password</a>--></div>
								
							</div>
							</form>
						</div>
						<!-- END OF THING -->
					</div>
				</div>
<!-- END OF HTML TEMPLATE -->

<?php
require('footer.php');
?>