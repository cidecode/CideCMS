<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/rolelist.php');	
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
							<div class="art-title">List of all roles (<?php echo $rolelist->pca; ?>)
								<?php if($permission->bpsw == 1){ ?>
								<a href="addrole.php" id="new_post_a">Add new role</a>
								<?php } ?>
							</div>
							<div class="article-block">
							<form action="<?php echo $constants->cwd; ?>" method="post">
								<table class="table-list">
									<thead>
										<th><input type="checkbox" id="all-check" /></th>
										<th>Role name</th>
										<th>Description</th>
										<th>Users</th>
										<th>Actions</th>
									</thead>
									<tbody>
									<?php while($v=mysqli_fetch_assoc($rolelist->grl)): ?>
										<tr class="plrow">
											<td><input type="checkbox" class="post-checks" name="role_check[]" value="<?php echo $v['ui']; ?>" /></td>
											<td><?php echo "<a href=\"editrole.php?r=".$v['ui']."\">".$v['sn']."</a>"; ?></td>
											<td><?php echo $v['sd']; ?></td>
											<td><?php echo $v['un']; ?></td>
											<td>
												<a href="<?php echo "editrole.php?r=".$v['ui']; ?>"><img src="img/edit.png" alt="Edit role" title="Edit role" /></a>
												<a href="<?php echo "delete.php?d=".$v['ui']."&t=role"."&h=".$host_uri->host_uri(); ?>"><img src="img/trash.png" alt="Delete role" title="Delete role" /></a>
											</td>
										</tr>
									<?php endwhile; ?>
									</tbody>
								</table>
								<select name="list_action">
									<option value="0">None</option>
									<option value="1">Delete</option>
								</select>
								<input type="submit" value="Jump on it" name="list_btn" />	
							</form>
							<!-- Page numbering (what page you at) -->
							<div id="page-numbering"><?php echo $rolelist->pagwr; ?></div>	
							</div>
						</div>
						<!-- END OF THING -->
					</div>
				</div>
<!-- END OF HTML TEMPLATE -->

<?php
require('footer.php');
?>