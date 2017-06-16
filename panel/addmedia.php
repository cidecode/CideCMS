<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/upload.php');
require('classes/addmedia.php');	
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
							<form action="<?php echo $constants->cwd; ?>" method="post" id="add-post" enctype="multipart/form-data">
							<div class="art-title">Upload new file
							<input type="submit" class="btn-submit" name="upload_file_btn" value="Upload" />
							<a href="media.php" class="top-btn-link">Back to media</a></div>
							<div class="article-block">
								<table class="user-list">
									<tbody>
										<tr>
											<td>Media preview</td>
											<td>
												<input type="file" name="upload" /><br />
												<span class="info">(Click the above button to select file you wish to upload.)</span>
											</td>
										</tr>
										<tr>
											<td>Name</td>
											<td>
												<input type="text" name="file_name" /><br />
												<span class="info">(You can leave it blank and change it later or change it now.)</span>
											</td>
										</tr>
										<tr>
											<td>Description</td>
											<td>
												<input type="text" name="file_desc" /><br />
												<span class="info">(You can leave it blank and change it later or change it now.)</span>
											</td>
										</tr>
										<tr>
											<td>Active</td>
											<td>
												<input type="checkbox" name="file_active" checked />Activate the file<br />
												<span class="info">(If you deactivate this file it can not be used anywhere except by using absolute path of file.)</span>
											</td>
										</tr>
									</tbody>
								</table>
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