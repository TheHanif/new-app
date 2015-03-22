<?php 
// Initialization
include_once 'include/init.php';

// Page title
$admin_title = 'Upload media';

// Header file
include 'include/header.php';
?>
<!-- BEGIN MAIN PAGE CONTENT -->
<div id="page-wrapper">
	<!-- BEGIN PAGE HEADING ROW -->
		<div class="row">
			<div class="col-lg-12">
				<!-- BEGIN BREADCRUMB -->
				<?php include 'include/breadcrumb.php'; ?>
				<!-- END BREADCRUMB -->	
				
				<div class="page-header title">
				<!-- PAGE TITLE ROW -->
					<h1><?php echo __($admin_title); ?> <a href="media.php" class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left"></i> <?php __('Cancel') ?></a></h1>								
				</div>
				
				<?php get_messages(); ?>	

			</div><!-- /.col-lg-12 -->
		</div><!-- /.row -->
	<!-- END PAGE HEADING ROW -->

		<?php
		// Check page for loack status
		get_lock_status(); ?>
		
		<div class="row">
			<div class="col-lg-12">
			
			<!-- START YOUR CONTENT HERE -->
				<form action="media_uploader.php" enctype="multipart/form-data" method="post">
					<input type="file" name="media[]" multiple>
					<input type="submit" name="submit" value="submit">
				</form>
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>