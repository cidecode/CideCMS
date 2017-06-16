<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/editcat.php');
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
							<form action="<?php echo $constants->cwd.'?c='.$editcat->id; ?>" method="post" id="add-post">
							<div class="art-title">Edit category
							<input type="submit" class="btn-submit" name="edit_cat_btn" <?php $permission->perm_btn_disable($permission->bctw); ?> value="Update" />
							<a href="categories.php" class="top-btn-link">Back to categories</a></div>
							<div class="article-block">
								
									<h3>Category name</h3>
									<input type="text" name="cat_name" class="post-title" value="<?php echo $editcat->cn; ?>" /><br />
									<h3>Category activation</h3>
									<?php echo $editcat->caa; ?>
									<h3>Category visibility</h3>
									<?php echo $editcat->cva; ?>
								
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