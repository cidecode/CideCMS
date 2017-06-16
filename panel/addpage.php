<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/addpage.php');
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
							<div class="art-title">Add new page
							<input type="submit" class="btn-submit" name="add_page_btn" value="Publish" />
							<a href="pages.php" class="top-btn-link">Back to pages</a></div>
							<div class="article-block">
								
									<h3>Title</h3>
									<input type="text" name="page_title" class="post-title" placeholder="Enter title here" /><br />
									<h3>Content</h3>
									<textarea name="page_content" id="post-content"></textarea><br />
									<h3>Page link</h3>
									<input type="text" name="page_link" /><br />
									<input type="text" style="display:none;" id="post_link" placeholder="grabautofill" />
									<span class="info">(You can customize custom link. Leave blank for auto generated.)</span>
									<h3>Author</h3>
									<select name="page_author">
									<?php while($v=$addpage->gu->fetch_assoc()): ?>
										<option value="<?php echo $v['us_id']; ?>"><?php echo $v['name']; ?></option>
									<?php endwhile; ?>
									</select><br />
									<h3>Parent</h3>
									<select name="page_parent">
										<option value="0">None</option>
									<?php while($v=$addpage->gp->fetch_assoc()): ?>
										<option value="<?php echo $v['po_id']; ?>"><?php echo $v['title']; ?></option>
									<?php endwhile; ?>
									</select><br />
									<h3>Page activation</h3>
									<input type="checkbox" name="page_active" checked />Activate page after publishing<br />
									<h3>Page comments</h3>
									<input type="checkbox" name="page_comments" />Allow comments on this page<br />
									<h3>Page protection</h3>
									<input type="checkbox" name="page_protect" id="post_protect" />Protect this page with password<br />
									<span class="info">(If you are moderating this page or it is a secret for public you can put password on it that only you know.)</span>
									<div id="post_protect_password"><h3>Enter post protection password: </h3><br />
									<input type="password" name="post_passwd" id="post-link" />
									<input type="password" style="display:none;" id="post_protect" placeholder="grabautofill" /></div>
								
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