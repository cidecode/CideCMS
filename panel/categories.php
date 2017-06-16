<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/catlist.php');	
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
							<div class="art-title">List of all categories (<?php echo $catlist->pca; ?>)
							<?php if($permission->bctw == 1){ ?>
							<a href="addcat.php" id="new_post_a">Add new category</a>
							<?php } 
							if($permission->bpsr == 1){ ?>
							<a href="posts.php" class="top-btn-link">Back to posts</a>
							<?php } ?>
							</div>
							<div class="article-block">
							<form action="<?php echo $constants->cwd; ?>" method="post">
								<table class="table-list">
									<thead>
										<th><input type="checkbox" id="all-check" /></th>
										<th>Name</th>
										<th>No. of posts</th>
										<th>Visible</th>
										<th>Active</th>
										<th>Actions</th>
									</thead>
									<tbody>
									<?php while($v=mysqli_fetch_assoc($catlist->gcl)): ?>
										<tr class="plrow">
											<td><input type="checkbox" class="post-checks" name="cat_checks[]" value="<?php echo $v['ci']; ?>" /></td>
											<td><a href="<?php echo "editcat.php?c=".$v['ci']; ?>"><?php echo $v['cn']; ?></a></td>
											<td><?php echo $v['pc']; ?></td>
											<td>
												<?php 
													if($v['vi'] == 1) echo "<img src=\"img/yes.png\" title=\"Visible to visitors\" />";
													else echo "<img src=\"img/no.png\" title=\"Not visible to visitors\" />";
												?>
											</td>
											<td>
												<?php 
													if($v['ac'] == 1) echo "<img src=\"img/yes.png\" title=\"Activated for usage\" />";
													else echo "<img src=\"img/no.png\" title=\"Not activated for usage\" />";
												?>
											</td>
											<td>
												<a href="<?php echo "editcat.php?c=".$v['ci']; ?>"><img src="img/edit.png" alt="Edit category" title="Edit category" /></a>
												<a href="<?php echo "delete.php?d=".$v['ci']."&t=category"."&h=".$host_uri->host_uri(); ?>"><img src="img/trash.png" alt="Delete category" title="Delete category" /></a>
												<a href="<?php echo "posts.php?c=".$v['ci']; ?>"><img src="img/view.png" alt="View category" title="View category" /></a>
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
									<option value="4">Visible</option>
									<option value="5">Not visible</option>
								</select>
								<input type="submit" value="Jump on it" name="list_btn" />	
								<?php if($permission->bpsr == 1){ ?>
									<span style="margin-left: 10px;">You can manage posts <b><a href="posts.php">here.</a></b></span>
								<?php } ?>
							</form>
							<!-- Page numbering (what page you at) -->
							<div id="page-numbering"><?php echo $catlist->pagwr; ?></div>
							</div>
						</div>
						<!-- END OF THING -->
					</div>
				</div>
<!-- END OF HTML TEMPLATE -->

<?php
require('footer.php');
?>