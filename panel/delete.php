<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/delete.php');
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
							<div class="art-title">Delete - <?php echo $delete->pt; ?></div>
							<div class="article-block post-del">
								
									<h3><?php echo $delete->pt; ?></h3><br />
									<span>Are you sure you want to delete this <?php echo $delete->type; ?>?</span><br />
									<a href="delete.php?d=<?php echo $delete->pi; ?>&ac=delete&h=<?php echo $_GET['h']; ?>&t=<?php echo $_GET['t']; ?>" class="btn" id="yes-del-btn">Yes, delete it</a>
									<a href="delete.php?d=<?php echo $delete->pi; ?>&ac=cancel&h=<?php echo $_GET['h']; ?>&t=<?php echo $_GET['t']; ?>" class="btn" id="no-del-btn">No, get me back</a>
							</div>
						</div>
						<!-- END OF THING -->
					</div>
				</div>
<!-- END OF HTML TEMPLATE -->

<?php
require('footer.php');
?>