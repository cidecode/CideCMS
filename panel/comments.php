<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/comlist.php');	
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
							<div class="art-title">List of all users (<?php echo $comlist->pca; ?>)</div>
							<div class="article-block">
							<form action="<?php echo $constants->cwd; ?>" method="post">
								<table class="table-list">
									<thead>
										<th><input type="checkbox" id="all-check" /></th>
										<th>Comment</th>
										<th>Full name</th>
										<th>Email</th>
										<th>Author</th>
										<th>Post</th>
										<th>Date posted</th>
										<th>Active</th>
										<th>Actions</th>
									</thead>
									<tbody>
									<?php while($v=mysqli_fetch_assoc($comlist->gcl)): ?>
										<tr class="plrow">
											<td><input type="checkbox" class="post-checks" name="comments_checks[]" value="<?php echo $v['ci']; ?>" /></td>
											<td><?php echo $v['ct']; ?></td>
											<td><?php echo $v['fn']; ?></td>
											<td><?php echo $v['em']; ?></td>
											<td><?php echo $v['un']; ?></td>
											<td><?php echo "<a href=\"".$v['ln']."\" target=\"_blank\">".$v['tl']."</a>"; ?></td>
											<td>
												<?php 
													echo date("d.m.Y",$v['cd'])."<br />".date("H:i:s",$v['cd']); 
												?>
											</td>
											<td>
												<?php 
													if($v['ac'] == 1) echo "<img src=\"img/yes.png\" />";
													else echo "<img src=\"img/no.png\" />";
												?>
											</td>
											<td>
												<a href="<?php echo "delete.php?d=".$v['ci']."&t=comment"."&h=".$host_uri->host_uri(); ?>"><img src="img/trash.png" alt="Delete comment" title="Delete comment" /></a>
												<a href="<?php echo $v['ln']; ?>" target="_blank"><img src="img/view.png" alt="View posts" title="View posts" /></a>
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
							<div id="page-numbering"><?php echo $comlist->pagwr; ?></div>	
							</div>
						</div>
						<!-- END OF THING -->
					</div>
				</div>
<!-- END OF HTML TEMPLATE -->

<?php
require('footer.php');
?>