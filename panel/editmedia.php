<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/upload.php');
require('classes/editmedia.php');
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

			new Clipboard('.btn');

		});

		// Copy to clipboard example
		document.querySelector("#copytoclipboard").onclick = function() {
		  // Select the content
		  document.querySelector("#linktocopy").select();
		  // Copy to the clipboard
		  document.execCommand('copy');

		  return false;
		};
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
							<form action="<?php echo $constants->cwd.'?f='.$editmedia->id; ?>" method="post" id="add-post" enctype="multipart/form-data">
							<div class="art-title">Edit media file (<?php echo $editmedia->nm; ?>)
							<input type="submit" class="btn-submit" name="edit_file_btn" value="Update" />
							<a href="media.php" class="top-btn-link">Back to media</a></div>
							<div class="article-block">
								<table class="user-list">
									<tbody>
										<tr>
											<td>Media preview</td>
											<td>
												<?php
													if(explode("/",$editmedia->mt)[0] == "image"){
														echo "<img src=\"$editmedia->ln\" class=\"media-small\" alt=\"$editmedia->dc\" />";
													}
													else{
														echo "<img src=\"img/doc.png\" class=\"media-small\" alt=\"$editmedia->dc\" /><br />
															  <span class\"info\">(There is no preview for this file.)</span><br />";
													}

												?>
												<br />
												<a href="<?php echo "delete.php?d=$editmedia->id&t=media"."&h=media.php"; ?>">Remove file</a>
												
											</td>
										</tr>
										<tr>
											<td>Name</td>
											<td>
												<input type="text" name="file_name" value="<?php echo $editmedia->nm; ?>" /><br />
												<span class="info">(You can change file name in what you want.)</span>
											</td>
										</tr>
										<tr>
											<td>Description</td>
											<td>
												<input type="text" name="file_desc" value="<?php echo $editmedia->dc; ?>" /><br />
												<span class="info">(You can change file description in what you want.)</span>
											</td>
										</tr>
										<tr>
											<td>Link</td>
											<td>
												<input type="text" name="file_link" id="linktocopy" value="<?php echo $editmedia->ln; ?>" />
												<span class="info">(This is absolute path to your file.)</span>
												<a href="<?php echo $editmedia->ln; ?>" target="_blank">Visit link</a>
												<button class="btn" data-clipboard-target="#linktocopy">Copy to clipboard</button>
												
											</td>
										</tr>
										<tr>
											<td>Type</td>
											<td>
												<input type="text" name="file_type" value="<?php echo $editmedia->mt; ?>" disabled /><br />
												<span class="info">(Registered type of uploaded file.)</span>
											</td>
										</tr>
										<tr>
											<td>Size</td>
											<td>
												<input type="text" name="file_size" value="<?php echo $editmedia->ms; ?>" disabled /><br />
												<span class="info">(File size in MB - MegaBytes)</span>
											</td>
										</tr>
										<tr>
											<td>Uploaded date</td>
											<td>
												<input type="text" name="file_date" value="<?php echo $editmedia->ud; ?>" disabled /><br />
												<span class="info">(Date and time when file was uploaded.)</span>
											</td>
										</tr>
										<tr>
											<td>Active</td>
											<td>
												<?php echo $editmedia->mfa; ?>
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