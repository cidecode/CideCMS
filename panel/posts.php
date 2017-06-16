<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/postlist.php');	
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
							<div class="art-title">List of all posts (<?php echo $postlist->pca; ?>)
								<?php if($permission->bpsw == 1){ ?>
								<a href="addpost.php" id="new_post_a">Add new post</a>
								<?php } 
								if($permission->bctr == 1){ ?>
								<a href="categories.php" class="top-btn-link">Categories</a>
								<?php } ?>
							</div>
							<div class="article-block">
							<form action="<?php echo $constants->cwd; ?>" method="post">
								<table class="table-list">
									<thead>
										<th><input type="checkbox" id="all-check" /></th>
										<th>Title</th>
										<th>Author</th>
										<th>Category</th>
										<th>Date</th>
										<th>Active</th>
										<th>Protected</th>
										<th>Actions</th>
									</thead>
									<tbody>
									<?php while($v=mysqli_fetch_assoc($postlist->gpl)): ?>
										<tr class="plrow">
											<td><input type="checkbox" class="post-checks" name="posts_checks[]" value="<?php echo $v['po_id']; ?>" /></td>
											<td><a href="<?php echo "editpost.php?a=".$v['po_id']; ?>"><?php echo $v['tt']; ?></a></td>
											<td><?php echo $v['nm']; ?></td>
											<td><?php echo $v['cn']; ?></td>
											<td><?php echo date("d.m.Y",$v['dt'])."<br />".date("H:m:s",$v['dt']); ?></td>
											<td>
												<?php 
													if($v['ac'] == 1) echo "<img src=\"img/yes.png\" />";
													else echo "<img src=\"img/no.png\" />";
												?>
											</td>
											<td>
												<?php 
													if($v['pr'] == 1) echo "<img src=\"img/yes.png\" />";
													else echo "<img src=\"img/no.png\" />";
												?>
											</td>
											<td>
												<a href="<?php echo "editpost.php?a=".$v['po_id']; ?>"><img src="img/edit.png" alt="Edit post" title="Edit post" /></a>
												<a href="<?php echo "delete.php?d=".$v['po_id']."&t=post"."&h=".$host_uri->host_uri(); ?>"><img src="img/trash.png" alt="Delete post" title="Delete post" /></a>
												<a href="<?php echo $v['ln']; ?>" target="_blank"><img src="img/view.png" alt="View post" title="View post" /></a>
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
								<?php if($permission->bctr == 1){ ?>
									<span style="margin-left: 10px;">You can manage categories <b><a href="categories.php">here.</a></b></span>
								<?php } ?>	
							</form>
							<!-- Page numbering (what page you at) -->
							<div id="page-numbering"><?php echo $postlist->pagwr; ?></div>	
							</div>
						</div>
						<!-- END OF THING -->
					</div>
				</div>
<!-- END OF HTML TEMPLATE -->

<?php
require('footer.php');
?>