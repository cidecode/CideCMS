<!-- body page -->
	<body>
		<!-- Whole page style -->
		<div id="body">
			<!-- Template style -->
			<div id="main">
				<!-- Header style -->
				<?php require('header.php'); ?>
				<?php require('menu.php'); ?>
				<!-- Main whole content style (articles and sidebar) -->
				<div id="wrap">
					<?php require('sidebar.php'); ?>
					<!-- article-list -->
					<div id="content">
						<!-- 
							# Listing all articles, DO NOT change PHP code, or otherwise your site won't work
							# You can modify HTML/CSS code
						-->
						<?php 
						if($permission->fpsr == 1){ 
						if($searchview->all_articles()){ while($v=mysqli_fetch_assoc($searchview->all_articles())): ?>
						<div class="article-block">
							<span class="art-title"><a href="<?php echo $v['ln']; ?>" name="artid"><?php echo $v['tt']; ?></a></span>
							<p>
								<?php if( (int)$v['pr'] != 1) echo $v['ct']; else echo "This content is password protected!"; ?>
								
							</p>
							<span class="art-sml">
								Posted <?php echo date("d.m.Y",$v['cd']); ?> |
								<a href="<?php echo $v['ln']; ?>" class="art-view-more" name="art-more">view more...</a>
							</span>
						</div>
						<?php endwhile; } else{ ?>
						<div class="article-block">
							<span class="art-title">Search engine couldn't find anything with: <?php echo $searchview->quest; ?></span>
						</div>
						<?php } ?>
						<!-- Page numbering (what page you at) -->
						<div id="page-numbering"><?php echo $searchview->pagwr; ?></div>	
						<?php } else{ ?>
						<div class="article-block">
							<span class="art-title">Access denied</span>
							<p>
								You don't have write to read this section.
							</p>
						</div>
						<?php } ?>
					</div>
				</div>
					
				