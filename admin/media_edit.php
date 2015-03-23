<?php 
// Initialization
include_once 'include/init.php';



$Media = new media();

$media = $Media->get_media($_GET['ID']);
$media = $media[0];

$file_url = SITEURL."contents/uploads/".$Media->_date('Y/m/d/', $media->date).$media->file;
$file_path = ABSPATH."contents/uploads/".$Media->_date('Y/m/d/', $media->date).$media->file;


// Page title
$admin_title = 'Edit media';

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
					<h1><?php echo __($admin_title); ?>
						<?php if(strpos($media->type, 'image') !== false && file_exists(str_replace('.', '-backup.', $file_path))): ?>
							<a href="media_edit.php?id=<?php echo $_GET['ID']; ?>&restore=true" class="btn btn-default btn-sm pull-right" id="upload"><i class="fa fa-refresh"></i> Restore original image</a>
						<?php endif; ?>
					</h1>								
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
				
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>