				
				<div class="clear"></div>
				<!-- Footer -->
				<div id="footer">
					<?php $permission->is_admin_footer(); echo $footer->grab_footer(); ?>
					<p><br />Built for you by <a href="http://www.cidecode.com" target="_blank">CideCode</a></p>
				</div>
			</div>	
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).ready(function() {
				  $('.test-popup-link').magnificPopup({type:'image'});
				});
			});
		</script>
	</body>
</html>