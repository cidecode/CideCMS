<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/editrole.php');
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
							<form action="<?php echo $constants->cwd.'?r='.$editrole->id; ?>" method="post" id="add-post">
							<div class="art-title">Edit role
							<input type="submit" class="btn-submit" name="edit_role_btn" <?php $permission->perm_btn_disable($permission->brlw); ?> value="Update" />
							<a href="roles.php" class="top-btn-link">Back to roles</a></div>
							<div class="article-block">
								
									<h3>Role name</h3>
									<input type="text" name="role_name" class="post-title" value="<?php echo $editrole->sn; ?>" /><br />
									<h3>Role description</h3>
									<input type="text" name="role_desc" class="post-title" value="<?php echo $editrole->sd; ?>" /><br /><br />
									<h3>Front panel access</h3>
									<table class="table-list role-table">
										<thead>
											<th>Section</th>
											<th>Read</th>
											<th>Write</th>
										</thead>
											<tr>
												<td>Index</td>
												<td><input type="checkbox" name="roles_box[0]" <?php $editrole->checkbox_status($editrole->c_finr); ?> /></td>
												<td><input type="checkbox" name="roles_box[1]" <?php $editrole->checkbox_status($editrole->c_finw); ?> /></td>
											</tr>
											<tr>
												<td>Pages</td>
												<td><input type="checkbox" name="roles_box[2]" <?php $editrole->checkbox_status($editrole->c_fpgr); ?> /></td>
												<td><input type="checkbox" name="roles_box[3]" <?php $editrole->checkbox_status($editrole->c_fpgw); ?> /></td>
											</tr>
											<tr>
												<td>Posts</td>
												<td><input type="checkbox" name="roles_box[4]" <?php $editrole->checkbox_status($editrole->c_fpsr); ?> /></td>
												<td><input type="checkbox" name="roles_box[5]" <?php $editrole->checkbox_status($editrole->c_fpsw); ?> /></td>
											</tr>
											<tr>
												<td>Comments</td>
												<td><input type="checkbox" name="roles_box[6]" <?php $editrole->checkbox_status($editrole->c_fcmr); ?> /></td>
												<td><input type="checkbox" name="roles_box[7]" <?php $editrole->checkbox_status($editrole->c_fcmw); ?> /></td>
											</tr>
											<tr>
												<td>Users</td>
												<td><input type="checkbox" name="roles_box[8]" <?php $editrole->checkbox_status($editrole->c_fusr); ?> /></td>
												<td><input type="checkbox" name="roles_box[9]" <?php $editrole->checkbox_status($editrole->c_fusw); ?> /></td>
											</tr>
											<tr>
												<td>Categories</td>
												<td><input type="checkbox" name="roles_box[10]" <?php $editrole->checkbox_status($editrole->c_fctr); ?> /></td>
												<td><input type="checkbox" name="roles_box[11]" <?php $editrole->checkbox_status($editrole->c_fctw); ?> /></td>
											</tr>
											<tr>
												<td>Registration</td>
												<td><input type="checkbox" name="roles_box[12]" <?php $editrole->checkbox_status($editrole->c_frlr); ?> /></td>
												<td><input type="checkbox" name="roles_box[13]" <?php $editrole->checkbox_status($editrole->c_frlw); ?> /></td>
											</tr>
									</table>
									<h3>Back panel access</h3>
									<table class="table-list role-table">
										<thead>
											<th>Section</th>
											<th>Read</th>
											<th>Write</th>
										</thead>
											<tr>
												<td>Control panel</td>
												<td><input type="checkbox" name="roles_box[14]" <?php $editrole->checkbox_status($editrole->c_bcpr); ?> /></td>
												<td><input type="checkbox" name="roles_box[15]" <?php $editrole->checkbox_status($editrole->c_bcpw); ?> /></td>
											</tr>
											<tr>
												<td>Pages</td>
												<td><input type="checkbox" name="roles_box[16]" <?php $editrole->checkbox_status($editrole->c_bpgr); ?> /></td>
												<td><input type="checkbox" name="roles_box[17]" <?php $editrole->checkbox_status($editrole->c_bpgw); ?> /></td>
											</tr>
											<tr>
												<td>Posts</td>
												<td><input type="checkbox" name="roles_box[18]" <?php $editrole->checkbox_status($editrole->c_bpsr); ?> /></td>
												<td><input type="checkbox" name="roles_box[19]" <?php $editrole->checkbox_status($editrole->c_bpsw); ?> /></td>
											</tr>
											<tr>
												<td>Categories</td>
												<td><input type="checkbox" name="roles_box[20]" <?php $editrole->checkbox_status($editrole->c_bctr); ?> /></td>
												<td><input type="checkbox" name="roles_box[21]" <?php $editrole->checkbox_status($editrole->c_bctw); ?> /></td>
											</tr>
											<tr>
												<td>Comments</td>
												<td><input type="checkbox" name="roles_box[22]" <?php $editrole->checkbox_status($editrole->c_bcmr); ?> /></td>
												<td><input type="checkbox" name="roles_box[23]" <?php $editrole->checkbox_status($editrole->c_bcmw); ?> /></td>
											</tr>
											<tr>
												<td>Media</td>
												<td><input type="checkbox" name="roles_box[24]" <?php $editrole->checkbox_status($editrole->c_bmdr); ?> /></td>
												<td><input type="checkbox" name="roles_box[25]" <?php $editrole->checkbox_status($editrole->c_bmdw); ?> /></td>
											</tr>
											<tr>
												<td>Users</td>
												<td><input type="checkbox" name="roles_box[26]" <?php $editrole->checkbox_status($editrole->c_busr); ?> /></td>
												<td><input type="checkbox" name="roles_box[27]" <?php $editrole->checkbox_status($editrole->c_busw); ?> /></td>
											</tr>
											<tr>
												<td>Roles</td>
												<td><input type="checkbox" name="roles_box[28]" <?php $editrole->checkbox_status($editrole->c_brlr); ?> /></td>
												<td><input type="checkbox" name="roles_box[29]" <?php $editrole->checkbox_status($editrole->c_brlw); ?> /></td>
											</tr>
											<tr>
												<td>Themes</td>
												<td><input type="checkbox" name="roles_box[30]" <?php $editrole->checkbox_status($editrole->c_bthr); ?> /></td>
												<td><input type="checkbox" name="roles_box[31]" <?php $editrole->checkbox_status($editrole->c_bthw); ?> /></td>
											</tr>
											<tr>
												<td>Options</td>
												<td><input type="checkbox" name="roles_box[32]" <?php $editrole->checkbox_status($editrole->c_botr); ?> /></td>
												<td><input type="checkbox" name="roles_box[33]" <?php $editrole->checkbox_status($editrole->c_botw); ?> /></td>
											</tr>
											<tr>
												<td>Plugins</td>
												<td><input type="checkbox" name="roles_box[34]" <?php $editrole->checkbox_status($editrole->c_bpur); ?> /></td>
												<td><input type="checkbox" name="roles_box[35]" <?php $editrole->checkbox_status($editrole->c_bpuw); ?> /></td>
											</tr>
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