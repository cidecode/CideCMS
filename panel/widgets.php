<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/widgetlist.php');	
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
			    $(".page-checks").prop("checked",$("#all-check").prop("checked"));
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
							<div class="art-title">List of all widgets (<?php echo $widgetlist->pca; ?>)
							<?php if($permission->bpgw == 1){ ?>
							<a href="addwidget.php" id="new_post_a">Add new widget</a>
							<?php } ?>
							</div>
							<div class="article-block">
							<form action="<?php echo $constants->cwd; ?>" method="post">
								<table class="table-list">
									<thead>
										<th><input type="checkbox" id="all-check" /></th>
										<th>Title</th>
										<th>Content</th>
										<th>Active</th>
										<th>Actions</th>
									</thead>
									<tbody>
									<?php while($v=mysqli_fetch_assoc($widgetlist->gwl)): ?>
										<tr class="plrow">
											<td><input type="checkbox" class="page-checks" name="widget_checks[]" value="<?php echo $v['wi']; ?>" /></td>
											<td><a href="<?php echo "editwidget.php?w=".$v['wi']; ?>"><?php echo $v['tt']; ?></a></td>
											<td><?php echo $v['ct']; ?></td>
											<td>
												<?php 
													if($v['ac'] == 1) echo "<img src=\"img/yes.png\" />";
													else echo "<img src=\"img/no.png\" />";
												?>
											</td>
											<td>
												<a href="<?php echo "editwidget.php?w=".$v['wi']; ?>"><img src="img/edit.png" alt="Edit widget" title="Edit widget" /></a>
												<a href="<?php echo "delete.php?d=".$v['wi']."&t=widget"."&h=".$host_uri->host_uri(); ?>"><img src="img/trash.png" alt="Delete widget" title="Delete widget" /></a>
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
							<div id="page-numbering"><?php echo $widgetlist->pagwr; ?></div>		
							</div>
						</div>
						<!-- END OF THING -->
					</div>
				</div>
<!-- END OF HTML TEMPLATE -->

<?php
require('footer.php');
?>