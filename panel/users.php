<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/userlist.php');	
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

			// Table effects
			$('.table-list tr.plrow').hover(
				function(){
					$(this).stop().animate({'background-color':'#4395cb',color:"#fff"},100);
					$(this).find('a').stop().animate({color:"#fff"},100);
				},
				function(){
					$(this).stop().animate({'background-color':'#fff',color:"#000"},100);
					$(this).find('a').stop().animate({color:"#1e6a92"},100);
				}
			);

			// Check all posts
			$("#all-check").click(function(){
			    $(".post-checks").prop("checked",$("#all-check").prop("checked"));
			});


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
							<div class="art-title">List of all users (<?php echo $userlist->pca; ?>)
							<?php if($permission->busw == 1){ ?>
							<a href="adduser.php" id="new_post_a">Add new user</a>
							<?php } ?></div>
							<div class="article-block">
							<form action="<?php echo $constants->cwd; ?>" method="post">
								<table class="table-list">
									<thead>
										<th><input type="checkbox" id="all-check" /></th>
										<th>Username</th>
										<th>Email</th>
										<th>Full name</th>
										<th>Display name</th>
										<th>Birth date</th>
										<th>Join date</th>
										<th>Active</th>
										<th>Role</th>
										<th>Actions</th>
									</thead>
									<tbody>
									<?php while($v=mysqli_fetch_assoc($userlist->gul)): ?>
										<tr class="plrow">
											<td><input type="checkbox" class="post-checks" name="users_checks[]" value="<?php echo $v['ui']; ?>" /></td>
											<td>
												<?php 
													if($v['ar'] != 'none')
														echo "<img src=\"".$v['ar']."\" class=\"avatar-small\" alt=\"".$v['un']."\" />";
													else
														echo "<img src=\"img/avatar.png\" class=\"avatar-small\" alt=\"".$v['un']."\" />"; 
												?>
												<a href="<?php echo "edituser.php?u=".$v['ui']; ?>"><?php echo $v['un']; ?></a>
											</td>
											<td><?php echo $v['ue']; ?></td>
											<td><?php echo $v['fn']; ?></td>
											<td><b><?php echo $v['dn']; ?></b></td>
											<td>
												<?php 
													if($v['bd'] != 'DD.MM.YYYY') 
														echo date("d.m.Y",$v['bd'])."<br />"; 
													else 
														echo 'none';
												?>
											</td>
											<td>
												<?php 
													if($v['jd'] != 'none') 
														echo date("d.m.Y",$v['jd'])."<br />".date("H:m:s",$v['jd']); 
													else 
														echo 'none';
												?>
											</td>
											<td>
												<?php 
													if($v['ac'] == 1) echo "<img src=\"img/yes.png\" />";
													else echo "<img src=\"img/no.png\" />";
												?>
											</td>
											<td title="<?php echo $v['sd']; ?>"><?php echo $v['sn']; ?></td>
											<td>
												<a href="<?php echo "edituser.php?u=".$v['ui']; ?>"><img src="img/edit.png" alt="Edit user" title="Edit user" /></a>
												<a href="<?php echo "delete.php?d=".$v['ui']."&t=user"."&h=".$host_uri->host_uri(); ?>"><img src="img/trash.png" alt="Delete user" title="Delete user" /></a>
												<a href="<?php echo "userview.php?u=".$v['ui']; ?>" target="_blank"><img src="img/view.png" alt="View posts and pages from this user" title="View posts and pages from this user" /></a>
											</td>
										</tr>
									<?php endwhile; ?>
									</tbody>
								</table>
								<select name="list_action">
									<option value="0">None</option>
									<option value="1">Delete</option>
									<option value="2">Active</option>
									<option value="3">Deactivate</option>
								</select>
								<input type="submit" value="Jump on it" name="list_btn" />	
							</form>
							<!-- Page numbering (what page you at) -->
							<div id="page-numbering"><?php echo $userlist->pagwr; ?></div>	
							</div>
						</div>
						<!-- END OF THING -->
					</div>
				</div>
<!-- END OF HTML TEMPLATE -->

<?php
require('footer.php');
?>