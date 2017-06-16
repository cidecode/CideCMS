<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/addrole.php');
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
							<form action="<?php echo $constants->cwd; ?>" method="post" id="add-post">
							<div class="art-title">Add role
							<input type="submit" class="btn-submit" name="add_role_btn" value="Add" />
							<a href="roles.php" class="top-btn-link">Back to roles</a></div>
							<div class="article-block">
								
									<h3>Role name</h3>
									<input type="text" name="role_name" class="post-title" /><br />
									<h3>Role description</h3>
									<input type="text" name="role_desc" class="post-title" /><br /><br />
									<h3>Front panel access</h3>
									<table class="table-list role-table">
										<thead>
											<th>Section</th>
											<th>Read</th>
											<th>Write</th>
										</thead>
											<tr>
												<td>Index</td>
												<td><input type="checkbox" name="roles_box[0]" /></td>
												<td><input type="checkbox" name="roles_box[1]" /></td>
											</tr>
											<tr>
												<td>Pages</td>
												<td><input type="checkbox" name="roles_box[2]" /></td>
												<td><input type="checkbox" name="roles_box[3]" /></td>
											</tr>
											<tr>
												<td>Posts</td>
												<td><input type="checkbox" name="roles_box[4]" /></td>
												<td><input type="checkbox" name="roles_box[5]" /></td>
											</tr>
											<tr>
												<td>Comments</td>
												<td><input type="checkbox" name="roles_box[6]" /></td>
												<td><input type="checkbox" name="roles_box[7]" /></td>
											</tr>
											<tr>
												<td>Users</td>
												<td><input type="checkbox" name="roles_box[8]" /></td>
												<td><input type="checkbox" name="roles_box[9]" /></td>
											</tr>
											<tr>
												<td>Categories</td>
												<td><input type="checkbox" name="roles_box[10]" /></td>
												<td><input type="checkbox" name="roles_box[11]" /></td>
											</tr>
											<tr>
												<td>Registration</td>
												<td><input type="checkbox" name="roles_box[12]" /></td>
												<td><input type="checkbox" name="roles_box[13]" /></td>
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
												<td><input type="checkbox" name="roles_box[14]" /></td>
												<td><input type="checkbox" name="roles_box[15]" /></td>
											</tr>
											<tr>
												<td>Pages</td>
												<td><input type="checkbox" name="roles_box[16]" /></td>
												<td><input type="checkbox" name="roles_box[17]" /></td>
											</tr>
											<tr>
												<td>Posts</td>
												<td><input type="checkbox" name="roles_box[18]" /></td>
												<td><input type="checkbox" name="roles_box[19]" /></td>
											</tr>
											<tr>
												<td>Categories</td>
												<td><input type="checkbox" name="roles_box[20]" /></td>
												<td><input type="checkbox" name="roles_box[21]" /></td>
											</tr>
											<tr>
												<td>Comments</td>
												<td><input type="checkbox" name="roles_box[22]" /></td>
												<td><input type="checkbox" name="roles_box[23]" /></td>
											</tr>
											<tr>
												<td>Media</td>
												<td><input type="checkbox" name="roles_box[24]" /></td>
												<td><input type="checkbox" name="roles_box[25]" /></td>
											</tr>
											<tr>
												<td>Users</td>
												<td><input type="checkbox" name="roles_box[26]" /></td>
												<td><input type="checkbox" name="roles_box[27]" /></td>
											</tr>
											<tr>
												<td>Roles</td>
												<td><input type="checkbox" name="roles_box[28]" /></td>
												<td><input type="checkbox" name="roles_box[29]" /></td>
											</tr>
											<tr>
												<td>Themes</td>
												<td><input type="checkbox" name="roles_box[30]" /></td>
												<td><input type="checkbox" name="roles_box[31]" /></td>
											</tr>
											<tr>
												<td>Options</td>
												<td><input type="checkbox" name="roles_box[32]" /></td>
												<td><input type="checkbox" name="roles_box[33]" /></td>
											</tr>
											<tr>
												<td>Plugins</td>
												<td><input type="checkbox" name="roles_box[34]" /></td>
												<td><input type="checkbox" name="roles_box[35]" /></td>
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