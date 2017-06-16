<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/medialist.php');	
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
							<div class="art-title">List of all media files (<?php echo $medialist->pca; ?>)
							<?php if($permission->bmdw == 1){ ?>
							<a href="addmedia.php" id="new_post_a">Add new file</a>
							<?php } ?></div>
							<div class="article-block">
							<form action="<?php echo $constants->cwd; ?>" method="post">
								<table class="table-list">
									<thead>
										<th><input type="checkbox" id="all-check" /></th>
										<th>Preview</th>
										<th>Name</th>
										<th>Description</th>
										<th>Type</th>
										<th>Size (MB)</th>
										<th>Upload date</th>
										<th>Active</th>
										<th>Actions</th>
									</thead>
									<tbody>
									<?php while($v=mysqli_fetch_assoc($medialist->gml)): ?>
										<tr class="plrow">
											<td><input type="checkbox" class="post-checks" name="files_checks[]" value="<?php echo $v['me']; ?>" /></td>
											<td class="media-width">
												<a href="<?php echo "editmedia.php?f=".$v['me']."&h=".$host_uri->host_uri(); ?>">
													<?php
														if(explode("/",$v['mt'])[0] == "image"){
															echo "<img src=\"".$v['ln']."\" class=\"media-small\" alt=\"".$v['dc']."\" />";
														}
														else{
															echo "<img src=\"img/no-preview.png\" class=\"media-small\" alt=\"".$v['dc']."\" />";
														}
													?>
												</a>
											</td>
											<td><?php echo $v['nm']; ?></td>
											<td><?php echo $v['dc']; ?></td>
											<td><?php echo $v['mt']; ?></td>
											<td>
												<?php
													$ms=round(($v['ms']/1024)/1024,2); 
													echo $ms; 
												?>
											</td>
											<td>
												<?php 
													
														echo date("d.m.Y",$v['ud'])."<br />".date("H:m:s",$v['ud']);
												?>
											</td>
											<td>
												<?php 
													if($v['ac'] == 1) echo "<img src=\"img/yes.png\" />";
													else echo "<img src=\"img/no.png\" />";
												?>
											</td>
											<td>
												<a href="<?php echo "editmedia.php?f=".$v['me']."&h=".$host_uri->host_uri(); ?>"><img src="img/edit.png" alt="Edit media file" title="Edit media file" /></a>
												<a href="<?php echo "delete.php?d=".$v['me']."&t=media"."&h=".$host_uri->host_uri(); ?>"><img src="img/trash.png" alt="Delete media file" title="Delete media file" /></a>
												<a href="<?php echo $v['ln']; ?>" target="_blank"><img src="img/view.png" alt="View media file" title="View media file" /></a>
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
							<div id="page-numbering"><?php echo $medialist->pagwr; ?></div>	
							</div>
						</div>
						<!-- END OF THING -->
					</div>
				</div>
<!-- END OF HTML TEMPLATE -->

<?php
require('footer.php');
?>