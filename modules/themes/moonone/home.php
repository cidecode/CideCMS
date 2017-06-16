<!-- article-list -->
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
<div id="content">
	<!-- 
		# Listing all articles, DO NOT change PHP code, or otherwise your site won't work
		# You can modify HTML/CSS code
	-->
	<?php 
	if($permission->fpsr == 1){ 
	while($v=mysqli_fetch_assoc($home->all_articles())): ?>
	<div class="article-block">
		<span class="art-title"><a href="<?php echo $v['ln']; ?>" name="artid"><?php echo $v['tt']; ?></a></span>
		<p>
			<?php if( (int)$v['pr'] != 1) echo $v['ct']; else echo "This content is password protected!"; ?>
			
		</p>
		<span class="art-sml">
			Posted <?php echo date("d.m.Y",$v['cd']); ?> by 
			<b><a href="user.php?u=<?php echo $v['ui']; ?>"><?php echo $v['nm']; ?></a></b>
			in <b><a href="category.php?c=<?php echo $v['ca']; ?>"><?php echo $v['cn']; ?></a></b> |
			<a href="<?php echo $v['ln']; ?>" class="art-view-more" name="art-more">view more...</a>
		</span>
	</div>
	<?php endwhile; ?>
	<!-- Page numbering (what page you at) -->
	<div id="page-numbering"><?php echo $home->pagwr; ?></div>	
	<?php } else{ ?>
	<div class="article-block">
		<span class="art-title">Access denied</span>
		<p>
			You don't have right to read this section.
		</p>
	</div>
	<?php } ?>
</div>