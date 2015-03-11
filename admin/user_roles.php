<?php 
// Initialization
include_once 'include/init.php';

// Page title
$admin_title = 'Roles and Capabilities';

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
					<h1 class='clearfix'><?php __($admin_title); ?> <a href="create_role.php" class="btn btn-default btn-sm pull-right"><i class="fa fa-plus"></i> <?php __('New Role') ?></a></h1>
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
				<p>This is a light-weight blank page, with minimum to none plugins loaded</p>
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>