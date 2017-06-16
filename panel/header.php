<!-- header (logo, welcome, search) -->
				<div id="header">
					<!-- Left side of header containing logo -->
					<div id="h-left">
						<div id="logo">
							<img src="img/ccpen.png">
							<a href="<?php echo $options->site_host().'panel'; ?>"><?php echo $options->site_name(); ?></a>
						</div>
					</div>
					<!-- Right side of header containing search box, etc.. -->
					<div id="h-right">
						<div class="info-block">
							<span>Welcome <span class="l-i"><a href="edituser.php?u=<?php echo $sessions->s_user_id; ?>"><?php echo $sessions->s_username; ?></a></span> (<a href="../login.php?action=logout">Logout</a>)</span>
						</div>
					</div>
				</div>