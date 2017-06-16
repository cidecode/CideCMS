<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/addwidget.php');
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
							<div class="art-title">Add new widget
							<input type="submit" class="btn-submit" name="add_widget_btn" value="Publish" />
							<a href="widgets.php" class="top-btn-link">Back to widgets</a></div>
							<div class="article-block">
								
									<h3>Title</h3>
									<input type="text" name="widget_title" class="post-title" placeholder="Enter title here" /><br />
									<h3>Content</h3>
									<textarea name="widget_content" id="post-content"></textarea><br />
									<h3>Page activation</h3>
									<input type="checkbox" name="widget_active" checked />Activate widget after publishing<br />
								
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