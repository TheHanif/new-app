<?php 
// Initialization
include_once 'include/init.php';

$themes = new themes();

$is_allowed = is_allowed(NULL, array('Site'=>array('manage-themes')));

// Settings object
$Settings = new settings();

// Proccess submited data
if (isset($_GET['loadtheme']) && $is_allowed) {

	if($themes->load_theme($_GET['loadtheme']) > 0){
		register_admin_message('Success', 'Theme loaded successfully.', 'success');
	}	
}

// Page title
$admin_title = 'Themes';

// List all installed theme from theme dir
$theme_list = $themes->get_theme_list();

// Current site theme
$current_theme = $themes->get_theme();

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
					<h1><?php echo __($admin_title); ?></h1>								
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
				<?php 
					foreach ($theme_list as $key => $info) {
						?>
							<div class="col-md-4 col-sm-3 col-xs-12 col-lg-2">
								<div class="panel <?php echo ($current_theme != $key)? 'panel-default' : 'panel-info'; ?>">
									<div class="panel-body">
										<img src="<?php echo $info['preview']; ?>" alt="<?php echo $info['name']; ?>" class="img-responsive">
										<ul class="list-group">
											<li class="list-group-item"><strong><?php __('Name:'); ?></strong> <?php echo $info['name']; ?></li>
											<li class="list-group-item"><strong><?php __('Author:'); ?></strong> <?php echo $info['author']; ?></li>
											<li class="list-group-item"><strong><?php __('Info:'); ?></strong> <?php echo $info['description']; ?></li>
										</ul>
										<a href="themes.php?loadtheme=<?php echo $key; ?>" class="btn btn-info <?php echo ($current_theme != $key)? '' : 'disabled'; ?>" title="<?php __('Apply theme'); ?>"><?php __('Apply theme'); ?></a>
										<a href="#" class="btn btn-danger <?php echo ($current_theme != $key)? '' : 'disabled'; ?>" title="<?php __('Delete theme'); ?>"><i class="fa fa-trash-o"></i> </a>
									</div>
								</div>
							</div>
						<?php
					}
				 ?>
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>