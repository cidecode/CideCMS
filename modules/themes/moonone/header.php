<!-- header (logo, welcome, search) -->
<div id="header">
					<!-- Left side of header containing logo -->
					<div id="h-left">
						<div id="logo"><?php echo $header->grab_logo_or_text(); ?></div>
					</div>
					<!-- Right side of header containing search box, etc.. -->
					<div id="h-right">
						<div class="info-block">
							<?php echo $sessions->user_info; ?>
						</div>
						<div id="searchbox">
							<form action="search.php" method="get">
								<input type="text" name="quest" <?php if(isset($_GET['quest'])) echo "value=\"".$_GET['quest']."\""; ?> />
							</form>
						</div>
					</div>
				</div>