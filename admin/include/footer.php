						<!-- BEGIN FOOTER CONTENT -->		
						<div class="footer">
							<div class="footer-inner">
								<!-- basics/footer -->
								<div class="footer-content">
									&copy; <?php echo date('Y'); ?> <a href="#">The Pure CMS</a>, All Rights Reserved.
								</div>
								<!-- /basics/footer -->
							</div>
						</div>
						<button type="button" id="back-to-top" class="btn btn-primary btn-sm back-to-top">
							<i class="fa fa-angle-double-up icon-only bigger-110"></i>
						</button>
					<!-- END FOOTER CONTENT -->
					
				</div><!-- /#page-wrapper -->	  
			<!-- END MAIN PAGE CONTENT -->
		</div>  
	</div> 
	 
    <!-- core JavaScript -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/js/plugins/pace/pace.min.js"></script>

	<!-- PAGE LEVEL PLUGINS JS -->
	<script src="assets/js/plugins/bootbox/bootbox.min.js"></script>

    <!-- Themes Core Scripts -->	
	<script src="assets/js/main.js"></script>
	
	<!-- REQUIRE FOR SPEECH COMMANDS -->
	<script src="assets/js/speech-commands.js"></script>
	<script src="assets/js/plugins/gritter/jquery.gritter.min.js"></script>	
	
	<script src="assets/js/plugins/bootstrap-wysihtml/wysihtml.min.js"></script>
	<script src="assets/js/plugins/bootstrap-wysihtml/bootstrap-wysihtml.js"></script>
	<script src="assets/js/plugins/bootstrap-editable/bootstrap-editable.min.js"></script>
	<script src="assets/js/plugins/colorBox/jquery.colorbox-min.js"></script>
	<script src="assets/js/plugins/slimscroll/jquery.slimscroll.init.js"></script>
	<script src="assets/js/plugins/bootstrap-select/bootstrap-select.min.js"></script>

	<script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
	<script src="assets/js/menus.js"></script>

	<script>

		var media_sizes = JSON.parse('<?php echo json_encode(get_media_sizes()); ?>');

		$('.selectpicker').selectpicker('show');
	
		$(document).ready(function() {
			// wysihtml editor
			$('#editor').wysihtml5();

			$('table th input:checkbox').on('click' , function(){
				var that = this;
				$(this).closest('table').find('tr > td:first-child input:checkbox')
				.each(function(){
					this.checked = that.checked;
					$(this).closest('tr').toggleClass('selected');
				});
					
			});
		});

		var SITEURL = '<?php echo SITEURL; ?>';

		// Media browser language text
		var browser_text = '<?php __('Browse'); ?>';
		var browser_remove = '<?php __('Remove'); ?>';

		// Handle permalink
		$("#name").bind("keyup change", function(e) {
			var value = $(this).val();
			$("#slug").val(function(i) {
				return $.trim(value.replace(/ /g, "-").toLowerCase());
			});	
		})

	</script>
	<script src="assets/js/media.js"></script>
	<!-- initial page level scripts for examples -->	
  </body>
</html>