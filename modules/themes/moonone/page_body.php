<!-- body page -->
	<body>
		<script>
	      window.fbAsyncInit = function() {
	        FB.init({
	          appId      : '862002447164447',
	          xfbml      : true,
	          version    : 'v2.1'
	        });
	      };

	      (function(d, s, id){
	         var js, fjs = d.getElementsByTagName(s)[0];
	         if (d.getElementById(id)) {return;}
	         js = d.createElement(s); js.id = id;
	         js.src = "//connect.facebook.net/en_US/sdk.js";
	         fjs.parentNode.insertBefore(js, fjs);
	       }(document, 'script', 'facebook-jssdk'));
	    </script>
	    <div id="fb-root"></div>
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
					<!-- Content -->
					<div id="content">
						<div class="article-block">
							<span class="art-title"><a href="<?php echo $ln; ?>" name="artid"><?php echo $pview->tt; ?></a></span><br />
							
							<div id="art-content"><?php echo $pview->ct; ?></div>
							<span class="art-sml">
								Posted <?php echo $pview->cdd." at ".$pview->cdt; ?> by 
								<b><a href="user.php?u=<?php echo $pview->ui; ?>"><?php echo $pview->nm; ?></a></b>
							</span>

						</div>
						<!-- comments -->
						<?php if($pview->cm == 1) require('comments.php'); ?>	
					</div>
				</div>
					
				