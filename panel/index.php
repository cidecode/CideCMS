<?php 
require('../load.php');
require('classes/messages.php');
require('meta.php');
require('classes/statistics.php');	
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
							<div class="art-title">Control panel - statistics</div>
							<div class="article-block">
								<div class="graphs">
									<div class="stat-panel">
										<table>
												<thead>
													<th colspan="2">Page statistics</th>
												</thead>
												<tr>
													<td>Number of all pages:</td>
													<td><?php echo $statistics->GrabStatistics("pagecountall"); ?></td>
												</tr>
												<tr>
													<td>Number of non-published pages:</td>
													<td><?php echo $statistics->GrabStatistics("pagecountnonpublished"); ?></td>
												</tr>
												<tr>
													<td>Number of published pages:</td>
													<td><?php echo $statistics->GrabStatistics("pagecountpublished"); ?></td>
												</tr>
												<tr>
													<td>Last page created:</td>
													<td><?php if($statistics->GrabStatistics("lastpagecreatedtitle") != "None"){?><a href="<?php echo "editpage.php?p=".$statistics->GrabStatistics("lastpagecreatedid"); ?>"><?php } echo $statistics->GrabStatistics("lastpagecreatedtitle"); ?></a></td>
												</tr>
												<tr>
													<td>Date last page was created:</td>
													<td><?php echo $statistics->GrabStatistics("lastpagecreatedate"); ?></td>
												</tr>
												<tr>
													<td>Last page modified:</td>
													<td><?php if($statistics->GrabStatistics("lastpagemodifytitle") != "None"){?><a href="<?php echo "editpage.php?p=".$statistics->GrabStatistics("lastpagemodifydid"); ?>"><?php } echo $statistics->GrabStatistics("lastpagemodifytitle"); ?></a></td>
												</tr>
												<tr>
													<td>Date last page was modified:</td>
													<td><?php echo $statistics->GrabStatistics("lastpagemodifydate"); ?></td>
												</tr>
											</table>
									</div>
									<div class="stat-panel">
										<table>
												<thead>
													<th colspan="2">User statistics</th>
												</thead>
												<tr>
													<td>Number of all users:</td>
													<td><?php echo $statistics->GrabStatistics("usercountall"); ?></td>
												</tr>
												<tr>
													<td>Number of non-verified users:</td>
													<td><?php echo $statistics->GrabStatistics("usercountnonverified"); ?></td>
												</tr>
												<tr>
													<td>Number of verified users:</td>
													<td><?php echo $statistics->GrabStatistics("usercountverified"); ?></td>
												</tr>
												<tr>
													<td>Last user registered:</td>
													<td><?php if($statistics->GrabStatistics("lastuserregisteredusername") != "None"){?><a href="<?php echo "edituser.php?u=".$statistics->GrabStatistics("lastuserregisteredid"); ?>"><?php } echo $statistics->GrabStatistics("lastuserregisteredusername"); ?></a></td>
												</tr>
												<tr>
													<td>Date last user was registered:</td>
													<td><?php echo $statistics->GrabStatistics("lastuserregisteredjoindate"); ?></td>
												</tr>
												<tr>
													<td>Number of administrators:</td>
													<td><?php echo $statistics->GrabStatistics("usercountadministrators"); ?></td>
												</tr>
												<tr>
													<td>Number of moderators:</td>
													<td><?php echo $statistics->GrabStatistics("usercountmoderators"); ?></td>
												</tr>
												<tr>
													<td>Number of authors:</td>
													<td><?php echo $statistics->GrabStatistics("usercountauthors"); ?></td>
												</tr>
												<tr>
													<td>Number of regular users:</td>
													<td><?php echo $statistics->GrabStatistics("usercountregularusers"); ?></td>
												</tr>
												<!--<tr>
													<td>Number of visitors:</td>
													<td><?php #echo $statistics->GrabStatistics("usercountvisitors"); ?></td>
												</tr>-->
											</table>
									</div>
									<div class="stat-panel">
										<table>
												<thead>
													<th colspan="2">Post statistics</th>
												</thead>
												<tr>
													<td>Number of all posts:</td>
													<td><?php echo $statistics->GrabStatistics("postcountall"); ?></td>
												</tr>
												<tr>
													<td>Number of non-published posts:</td>
													<td><?php echo $statistics->GrabStatistics("postcountnonpublished"); ?></td>
												</tr>
												<tr>
													<td>Number of published posts:</td>
													<td><?php echo $statistics->GrabStatistics("postcountpublished"); ?></td>
												</tr>
												<tr>
													<td>Last post created:</td>
													<td><?php if($statistics->GrabStatistics("lastpostcreatedtitle") != "None"){?><a href="<?php echo "editpost.php?p=".$statistics->GrabStatistics("lastpostcreatedid"); ?>"><?php } echo $statistics->GrabStatistics("lastpostcreatedtitle"); ?></a></td>
												</tr>
												<tr>
													<td>Date last post was created:</td>
													<td><?php echo $statistics->GrabStatistics("lastpostcreatedate"); ?></td>
												</tr>
												<tr>
													<td>Last post modified:</td>
													<td><?php if($statistics->GrabStatistics("lastpostmodifytitle") != "None"){?><a href="<?php echo "editpost.php?p=".$statistics->GrabStatistics("lastpostmodifydid"); ?>"><?php } echo $statistics->GrabStatistics("lastpostmodifytitle"); ?></a></td>
												</tr>
												<tr>
													<td>Date last post was modified:</td>
													<td><?php echo $statistics->GrabStatistics("lastpostcreatedate"); ?></td>
												</tr>
											</table>
									</div>
									<div class="stat-panel">
										<table>
												<thead>
													<th colspan="2">Comment statistics</th>
												</thead>
												<tr>
													<td>Number of all comments:</td>
													<td><?php echo $statistics->GrabStatistics("commentcountall"); ?></td>
												</tr>
												<tr>
													<td>Number of non-approved comments:</td>
													<td><?php echo $statistics->GrabStatistics("commentcountnonapproved"); ?></td>
												</tr>
												<tr>
													<td>Number of approved comments:</td>
													<td><?php echo $statistics->GrabStatistics("commentcountapproved"); ?></td>
												</tr>
												<tr>
													<td>Last comment created:</td>
													<td><?php echo $statistics->GrabStatistics("lastcommentcreatedcontent"); ?></td>
												</tr>
												<tr>
													<td>Date last comment was created:</td>
													<td><?php echo $statistics->GrabStatistics("lastcommentcreatedate"); ?></td>
												</tr>
											</table>
									</div>

								</div>
							</div>
						</div>
						<!-- END OF THING -->
					</div>
				</div>
<!-- END OF HTML TEMPLATE -->

<?php
require('footer.php'); 
?>