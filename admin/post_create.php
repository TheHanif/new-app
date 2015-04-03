<?php 
// Initialization
include_once 'include/init.php';

$ID = (isset($_GET['ID']))? $_GET['ID'] : NULL;

// Get type for custom post
$type = $_GET['type'];

// Get data of custom post from global post container
$custom_post = $posts[$type];
$custom_name = $custom_post['meta']['single_title'];

// Page title
$admin_title = (isset($ID))? 'Edit '.$custom_name : 'New '.$custom_name;



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
					<h1><?php echo __($admin_title); ?> <span class="sub-title"><?php __(ucfirst($type)); ?></span> </h1>								
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