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
		
		<!-- START YOUR CONTENT HERE -->
		<div class="row">
			<form action="<?php echo get_actual_url(false); ?>" role="form" method="post">
				<div class="col-md-9">
					<div class="form-group">
						<label for="name" class="sr-only"><?php echo ucfirst($custom_name).' '; __('name') ?></label>
						<input type="text" class="form-control input-lg" style="font-weight:bold;" id="name" placeholder="<?php echo ucfirst($custom_name).' '; __('name') ?>">
					</div><!-- Name -->

					<div class="form-group">
						<label for="slug">Slug</label>
						<input type="text" class="form-control" id="slug" name="slug">
					</div>
				</div><!-- end of main contents -->
				<div class="col-md-3">2</div><!-- end of sidebar -->
			</form>
		</div>
		<!-- END YOUR CONTENT HERE -->
<?php include 'include/footer.php'; ?>