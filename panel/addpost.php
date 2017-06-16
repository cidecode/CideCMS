<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/addpost.php');
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
							<div class="art-title">Add new post
							<input type="submit" class="btn-submit" name="add_post_btn" value="Publish" />
							<a href="posts.php" class="top-btn-link">Back to posts</a></div>
							<div class="article-block">
								
									<h3>Title</h3>
									<input type="text" name="post_title" class="post-title" placeholder="Enter title here" /><br />
									<h3>Content</h3>
									<textarea name="post_content" id="post-content"></textarea><br />
									<h3>Post link</h3>
									<input type="text" name="post_link" /><br />
									<input type="text" style="display:none;" id="page_link" placeholder="grabautofill" />
									<span class="info">(You can customize custom link. Leave blank for auto generated.)</span>
									<h3>Author</h3>
									<select name="post_author">
									<?php while($v=$addpost->gu->fetch_assoc()): ?>
										<option value="<?php echo $v['us_id']; ?>"><?php echo $v['name']; ?></option>
									<?php endwhile; ?>
									</select><br />
									<h3>Category</h3>
									<select name="post_category">
									<?php while($v=$addpost->gc->fetch_assoc()): ?>
										<option value="<?php echo $v['ca_id']; ?>"><?php echo $v['cat_name']; ?></option>
									<?php endwhile; ?>
									</select><br /><a href="addcat.php">Add new category</a><br />
									<h3>Post activation</h3>
									<input type="checkbox" name="post_active" checked />Activate post after publishing<br />
									<h3>Post comments</h3>
									<input type="checkbox" name="post_comments" checked />Allow comments on this post<br />
									<h3>Post protection</h3>
									<input type="checkbox" name="post_protect" id="post_protect" />Protect this post with password<br />
									<span class="info">(If you are moderating this post/page or it is a secret for public you can put password on it that only you now.)</span>
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