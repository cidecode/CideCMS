<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/poptions.php');	
?>

<!-- HTML TEMPLATE -->
<!-- body page -->
	<body>
		<script type="text/javascript">
		$(document).ready(function(){
			// Post password protection
			if($('#post_protect').attr("checked")) $('#post_protect_password').show();
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
							<form action="<?php echo $constants->cwd; ?>" method="post" id="add-post" enctype="multipart/form-data">
							<div class="art-title">Site options 
							<input type="submit" class="btn-submit" name="edit_options_btn" <?php $permission->perm_btn_disable($permission->botw); ?> value="Update" />
							</div>
							<div class="article-block">
								<table class="user-list">
									<tbody>
										<tr>
											<td>Site name</td>
											<td>
												<input type="text" name="site_name" value="<?php echo $paneloptions->OptionValue('site_name'); ?>" /><br />
												<span class="info">(This is your main site name that is viewable by all visitors.)</span>
											</td>
										</tr>
										<tr>
											<td>Site description</td>
											<td>
												<input type="text" name="site_desc" value="<?php echo $paneloptions->OptionValue('site_desc'); ?>" /><br />
												<span class="info">(This is your main site description. It is used for meta tags.)</span>
											</td>
										</tr>
										<tr>
											<td>Main site admin</td>
											<td>
												<b><?php echo $paneloptions->gan; ?></b>
												<select name="site_admin">
												<?php while($v=mysqli_fetch_assoc($paneloptions->gas)):
													if($paneloptions->OptionValue('site_admin') == $v['us_id']){ 
														echo "<option value=\"".$v['us_id']."\" selected>".$v['username']."</option>";
													}
													else{
														echo "<option value=\"".$v['us_id']."\">".$v['username']."</option>";
													}
												 endwhile; ?>
												</select><br />
												<span class="info">(This can only be changed by the main site admin.)</span>
											</td>
										</tr>
										<tr>
											<td>Main site email</td>
											<td>
												<input type="text" name="site_email" value="<?php echo $paneloptions->OptionValue('site_email'); ?>" /><br />
												<span class="info">(This can only by changed by the main site admin.)</span>
											</td>
										</tr>
										<tr>
											<td>Logo</td>
											<td>
												<?php 
													if($paneloptions->OptionValue('site_logo') != NULL)
														echo "<img src=\"".$paneloptions->OptionValue('site_logo')."\" class=\"logo-panel\" alt=\"\" />";
													else
														echo "<img src=\"img/no-preview.png\" class=\"logo-panel\" alt=\"\" />"; 
												?>
												<br /><input type="file" name="upload" /><br />
												<span class="info">(Click to change sites logo.)</span><br />
												<?php if($paneloptions->OptionValue('site_logo') != NULL){ ?>
												<a href="options.php?rm=logo&lg=<?php echo $paneloptions->OptionValue('site_logo'); ?>">Remove logo</a>
												<?php } ?>
												<br />
												<input type="text" name="site_logo" value="<?php echo $paneloptions->OptionValue('site_logo'); ?>" /><br />
												<span class="info">(Or change your logo from external link.)</span>
											</td>
										</tr>
										<tr>
											<td>Site host</td>
											<td>
												<input type="text" name="site_host" value="<?php echo $paneloptions->OptionValue('site_host'); ?>" /><br />
												<span class="info">(Be careful with changing this option. If changed without coution the site might not work.)</span>
											</td>
										</tr>
										<tr>
											<td>Theme in usage</td>
											<td>
												<input type="text" value="<?php echo $paneloptions->OptionValue('site_theme'); ?>" disabled /><br />
												<span class="info">(You can change site theme <a href="themes.php">here</a>.)</span>
											</td>
										</tr>
										<tr>
											<td>Number of articles per page</td>
											<td>
												<input type="text" name="articles_per_page" value="<?php echo $paneloptions->OptionValue('articles_per_page'); ?>" /><br />
												<span class="info">(Number of articles showen at home page.)</span>
											</td>
										</tr>
										<tr>
											<td>Site footer</td>
											<td>
												<textarea name="site_footer"><?php echo $paneloptions->OptionValue('site_footer'); ?></textarea><br />
												<span class="info">(This will appear at bottom of the site.)</span>
											</td>											
										</tr>
										<tr>
											<td>Comments</td>
											<td>
												<?php 
													if($paneloptions->OptionValue('site_com') == "1") echo "<input type=\"checkbox\" name=\"site_com\" checked />Allow comments on posts and pages<br />";
													else echo "<input type=\"checkbox\" name=\"site_com\" />Allow comments on posts and pages<br />";
												?>
												<span class="info">(Checking this option everyone have permision to comment on posts and pages.)</span>
											</td>
										</tr>
										<tr>
											<td>Tracking</td>
											<td>
												<?php 
													if($paneloptions->OptionValue('tracking') == "1") echo "<input type=\"checkbox\" name=\"tracking\" checked />Allow user tracking system<br />";
													else echo "<input type=\"checkbox\" name=\"tracking\" />Allow user tracking system<br />";
												?>
												<span class="info">(This allows you to track database activity for all users. Check log <a href="tracking.php">here</a>.)</span>
											</td>
										</tr>
										<tr>
											<td>RSS feed</td>
											<td>
												<?php 
													if($paneloptions->OptionValue('site_rss') == "1") echo "<input type=\"checkbox\" name=\"site_rss\" checked />Allow rss feed for posts<br />";
													else echo "<input type=\"checkbox\" name=\"site_rss\" />Allow rss feed for posts<br />";
												?>
												<span class="info">(If checked it creates rss feed for your site posts. Click <a href="<?php echo $options->site_host().'/rss.xml'; ?>">here</a> to view rss feed.)</span>
											</td>
										</tr>
										<tr>
											<td>Sitemap</td>
											<td>
												<?php
													if($paneloptions->OptionValue('sitemap') == "1") echo "<input type=\"checkbox\" name=\"sitemap\" checked />Allow sitemap for pages<br />";
													else echo "<input type=\"checkbox\" name=\"sitemap\" />Allow sitemap for pages<br />";
												?>
												<span class="info">(If checked it creates sitemap for your site pages - Google likes it. Click <a href="<?php echo $options->site_host().'/sitemap.xml'; ?>">here</a> to view sitemap.)</span>
											</td>
										</tr>
										<tr>
											<td>Main permission</td>
											<td>
												<select name="main_perm">
												<?php  while($v=mysqli_fetch_assoc($paneloptions->gap)):
													if($paneloptions->OptionValue('main_perm') == $v['ut_id']){ 
														echo "<option value=\"".$v['ut_id']."\" selected>".$v['status_name']."</option>";
													}
													else{
														echo "<option value=\"".$v['ut_id']."\">".$v['status_name']."</option>";
													}
												 endwhile; ?>
												</select><br />
												<span class="info">(This can only be changed by the main site admin.)</span>
											</td>
										</tr>
										<tr>
											<td>Offline status</td>
											<td>
												<?php
													if($paneloptions->OptionValue('site_mod') == "1") echo "<input type=\"checkbox\" name=\"site_mod\" checked />Site is offline to all visitors<br />";
													else echo "<input type=\"checkbox\" name=\"site_mod\" />Site is offline to all visitors<br />";
												?>
												<span class="info">(Checking this option the site will enter offline status and it won't be accessed by visitors. This option is used when the site is being moderating.)</span>
											</td>
										</tr>
										<tr>
											<td>SMTP host</td>
											<td>
												<input type="text" name="smtp_host" value="<?php echo $paneloptions->OptionValue('smtp_host'); ?>" /><br />
												<span class="info">(Specify main and backup SMTP servers comma-separeted: smtp1.example.com;smtp2.example.com.)</span>
											</td>
										</tr>
										<tr>
											<td>SMTP username</td>
											<td>
												<input type="text" name="smtp_username" value="<?php echo $paneloptions->OptionValue('smtp_username'); ?>" /><br />
												<span class="info">(Enter your SMTP username/email.)</span>
											</td>
										</tr>
										<tr>
											<td>SMTP password</td>
											<td>
												<input type="password" name="smtp_passwd" /><br />
												<span class="info">(Enter your SMTP password. THIS PASSWORD IS NOT ENCRYPTED!)</span>
											</td>
										</tr>
										<tr>
											<td>SMTP encryption</td>
											<td>
												<input type="text" name="smtp_secure" value="<?php echo $paneloptions->OptionValue('smtp_secure'); ?>" /><br />
												<span class="info">(Enter SMTP encryption: TLS or SSL.)</span>
											</td>
										</tr>
										<tr>
											<td>SMTP port</td>
											<td>
												<input type="text" name="smtp_port" value="<?php echo $paneloptions->OptionValue('smtp_port'); ?>" /><br />
												<span class="info">(Enter SMTP port.)</span>
											</td>
										</tr>
										<tr>
											<td>SMTP send email as</td>
											<td>
												<input type="text" name="smtp_send_as" value="<?php echo $paneloptions->OptionValue('smtp_send_as'); ?>" /><br />
												<span class="info">(Enter the email caddress from what you will send emails.)</span>
											</td>
										</tr>
										
									</tbody>
								</table>
							</div>
							</form>
						</div>
						<!-- END OF THING -->
					</div>
				</div>
<!-- END OF HTML TEMPLATE -->

<?php
require('footer.php');
?>