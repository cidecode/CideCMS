<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/upload.php');
require('classes/adduser.php');
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
							<div class="art-title">Add new user
							<input type="submit" class="btn-submit" name="add_user_btn" value="Add" />
							<a href="users.php" class="top-btn-link">Back to users</a></div>
							<div class="article-block">
								<table class="user-list">
									<tbody>
										<tr>
											<td>Avatar </td>
											<td>
												<img src="img/avatar.png" class="avatar" alt="" />
												<br /><input type="file" name="upload" /><br />
												<span class="info">(Click to change your profile image.)</span>
											</td>
										</tr>
										<tr>
											<td>Username</td>
											<td>
												<input type="text" name="user_name" placeholder="example" /><br />
												<span class="info">(User name can not be changed.)</span>
											</td>
										</tr>
										<tr>
											<td>Password</td>
											<td>
												<input type="password" name="user_passwd1" placeholder="********" /><br />
												<span class="info">(Enter password or <a href="javascript:void(0)" id="pass_gen">use generator</a>.)</span>
											</td>
										</tr>
										<tr>
											<td>Re-password</td>
											<td>
												<input type="password" name="user_passwd2" placeholder="********" /><br />
												<span class="info">(Re-enter above password.)</span>
											</td>
										</tr>
										<tr>
											<td>User email</td>
											<td>
												<input type="text" name="user_email" placeholder="example@example.com" /><br />
												<span class="info">(Your personal email address.)</span>
											</td>
										</tr>
										<tr>
											<td>Full name</td>
											<td>
												<input type="text" name="full_name" placeholder="First and last name" /><br />
												<span class="info">(You can leave it blank.)</span>
											</td>
										</tr>
										<tr>
											<td>Birth date</td>
											<td>
												<input type="text" name="birth_date" placeholder="DD.MM.YYYY" /><br />
												<span class="info">(Enter it in format writen above or you can leave it blank.)</span>
											</td>
										</tr>
										<tr>
											<td>Join date</td>
											<td>
												<input type="text" name="join_date" value="<?php echo date("d.m.Y"); ?>" disabled /><br />
												<span class="info">(Join date can not be changed.)</span>
											</td>
										</tr>
										<tr>
											<td>Role</td>
											<td> 
												<select name="user_role">
												<?php  while($v=$adduser->gur->fetch_assoc()):
													echo "<option value=\"".$v['ut_id']."\" title=\"".$v['usd']."\">".$v['usn']."</option>";
											
													endwhile; ?>
												</select><br />
												<span class="info">(Choose users role. You can edit them <a href="roles.php">here</a>.)</span>
												
											</td>
										</tr>
										<tr>
											<td>Active</td>
											<td><input type="checkbox" name="user_active" checked />Activate the user<br /></td>
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