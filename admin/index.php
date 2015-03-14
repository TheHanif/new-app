<?php 
// Initialization
include_once 'include/init.php';

// Page title
$admin_title = 'Dashboard';

// Variable to active select page
// $page = get_script_name();

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
					<h1><?php echo __($admin_title); ?> <span class="sub-title">sub title</span></h1>								
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
			<?php print_f($admin_sidebar_navigation); ?>
			<?php 
			if (HAS_USERS) {
				echo 1;
			}
			 ?>
			<!-- START YOUR CONTENT HERE -->
				<p>This is a light-weight blank page, with minimum to none plugins loaded</p>
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>