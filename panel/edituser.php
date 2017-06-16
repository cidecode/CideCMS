<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/upload.php');
require('classes/edituser.php');
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
							<form action="<?php echo $constants->cwd.'?u='.$edituser->id; ?>" method="post" id="add-post" enctype="multipart/form-data">
							<div class="art-title">Edit user (<?php echo $edituser->un; ?>)
							<input type="submit" class="btn-submit" name="edit_user_btn" <?php $permission->perm_btn_disable($permission->busw); ?> value="Update" />
							<a href="users.php" class="top-btn-link">Back to users</a></div>
							<div class="article-block">
								<table class="user-list">
									<tbody>
										<tr>
											<td>Avatar </td>
											<td>
												<?php 
													if($edituser->ar != 'none')
														echo "<img src=\"$edituser->ar\" class=\"avatar\" alt=\"$edituser->un\" />";
													else
														echo "<img src=\"img/avatar.png\" class=\"avatar\" alt=\"$edituser->un\" />"; 
												?>
												<br /><input type="file" name="upload" /><br />
												<span class="info">(Click to change your profile image.)</span><br />
												<?php if($edituser->ar != 'none'){ ?>
												<a href="edituser.php?rm=avatar&u=<?php echo $edituser->id; ?>&av=<?php echo $edituser->ar; ?>">Remove avatar</a>
												<?php } ?>
											</td>
										</tr>
										<tr>
											<td>Username</td>
											<td>
												<input type="text" name="user_name" value="<?php echo $edituser->un; ?>" disabled /><br />
												<span class="info">(User name can not be changed. Be careful with changing it in data base.)</span>
											</td>
										</tr>
										<tr>
											<td>Password</td>
											<td>
												<input type="password" name="user_passwd" /><br />
												<span class="info">(Do not enter anything in this field if you do not want to change password.)</span>
											</td>
										</tr>
										<tr>
											<td>User email</td>
											<td><input type="text" name="user_email" value="<?php echo $edituser->ue; ?>" /></td>
										</tr>
										<tr>
											<td>Full name</td>
											<td><input type="text" name="full_name" value="<?php echo $edituser->fn; ?>" /></td>
										</tr>
										<tr>
											<td>Display name</td>
											<td>
												<select name="display_name">
												<?php while($v=$edituser->gdn->fetch_assoc()):
													if($v['full_name'] == $v['nickname'] && $v['full_name'] != ''){ 
														echo "<option value=\"".$v['full_name']."\" selected>".$v['full_name']."</option>";
														echo "<option value=\"".$v['username']."\">".$v['username']."</option>";
													}
													else{
														echo "<option value=\"".$v['username']."\" selected>".$v['username']."</option>";
														echo "<option value=\"".$v['full_name']."\">".$v['full_name']."</option>";
													}
												 endwhile; ?>
												</select><br />
												<span class="info">(This is name that will be displayed to visitors.)</span>
											</td>
										</tr>
										<tr>
											<td>Birth date</td>
											<td>
												<input type="text" name="birth_date" value="<?php echo $edituser->bd; ?>" /><br />
												<span class="info">(Enter it in format writen above.)</span>
											</td>
										</tr>
										<tr>
											<td>Join date</td>
											<td>
												<input type="text" name="join_date" value="<?php echo $edituser->jd; ?>" disabled /><br />
												<span class="info">(Join date can not be changed.)</span>
											</td>
										</tr>
										<tr>
											<td>Role</td>
											<td> 
												<?php 
													if($edituser->id == 1)
														echo "Role of first registered user can not be changed.";
													else{ ?> 
													<select name="user_role">
													<?php  while($v=$edituser->gur->fetch_assoc()):
														if($v['ut_id'] == $edituser->us){ 
															echo "<option value=\"".$v['ut_id']."\" title=\"".$v['usd']."\" selected>".$v['usn']."</option>";
														}
														else{
															echo "<option value=\"".$v['ut_id']."\" title=\"".$v['usd']."\">".$v['usn']."</option>";
														}
													 endwhile; ?>
													</select><br />
													<span class="info">(Choose users role. You can edit them <a href="roles.php">here</a>.)</span>
													<?php } ?>
											</td>
										</tr>
										<tr>
											<td>Active</td>
											<td><?php echo $edituser->uaa; ?></td>
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