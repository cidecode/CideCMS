<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/editpage.php');
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
							<form action="<?php echo $constants->cwd.'?p='.$editpage->id; ?>" method="post" id="add-post">
							<div class="art-title">Edit page
							<input type="submit" class="btn-submit" name="edit_page_btn" <?php $permission->perm_btn_disable($permission->bpgw); ?> value="Update" />
							<a href="pages.php" class="top-btn-link">Back to pages</a></div>
							<div class="article-block">
								
									<h3>Title</h3>
									<input type="text" name="page_title" class="post-title" value="<?php echo $editpage->pt; ?>" /><br />
									<h3>Content</h3>
									<textarea name="page_content" id="post-content"><?php echo $editpage->pc; ?></textarea><br />
									<h3>Page link</h3>
									<input type="text" name="page_link" id="post-link" value="<?php echo $editpage->pl; ?>" /><br />
									<span class="info">(You can customize custom link)</span>
									<h3>Author</h3>
									<select name="page_author">
									<?php while($v=$editpage->gu->fetch_assoc()){ 
										if($v['us_id'] == $editpage->ui)
											echo "<option value=\"".$v['us_id']."\" selected>".$v['name']."</option>";
										else
											echo "<option value=\"".$v['us_id']."\">".$v['name']."</option>";
									} ?>
									</select><br />
									<h3>Parent</h3>
									<select name="page_parent">
									<option value="0">None</option>
									<?php while($v=$editpage->gp->fetch_assoc()){
										if($v['po_id'] == $editpage->pr)
											echo "<option value=\"".$v['po_id']."\" selected>".$v['title']."</option>";
										else
											echo "<option value=\"".$v['po_id']."\">".$v['title']."</option>";
									} ?>
									</select><br />
									<h3>Page activation</h3>
									<?php echo $editpage->paa; ?>
									<h3>Page activation</h3>
									<?php echo $editpage->pcm; ?>
									<h3>Page protection</h3>
									<?php echo $editpage->ppp; ?>
									<span class="info">(If you are moderating this post/page or it is a secret for public you can put password on it that only you now.)</span>
									<div id="post_protect_password"><h3>Enter post protection password: </h3><br />
									<input type="password" name="post_passwd" id="post-link" /></div>
								
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