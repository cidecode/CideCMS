<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/addcat.php');
?>

<!-- HTML TEMPLATE -->
<!-- body page -->
	<body>
		<script type="text/javascript">
		$(document).ready(function(){
			// Post password protection
			if($('#post_protect').checked) $('#post_protect_password').show();
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
							<form action="<?php echo $constants->cwd; ?>" method="post" id="add-post">
							<div class="art-title">Add new category
							<input type="submit" class="btn-submit" name="add_cat_btn" value="Add" />
							<a href="categories.php" class="top-btn-link">Back to categories</a></div>
							<div class="article-block">
								
									<h3>Category name</h3>
									<input type="text" name="cat_name" class="post-title" placeholder="Enter name here" /><br />
									<h3>Category activation</h3>
									<input type="checkbox" name="cat_active" checked />Activate category for usage<br />
									<span class="info">(If unchecked posts can not be assigned to this category)</span>
									<h3>Post protection</h3>
									<input type="checkbox" name="cat_visible" checked />Category is visible to visitors<br />
									<span class="info">(If unchecked visitors can not view list of posts assigned to this category)</span>
								
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