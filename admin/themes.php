<?php 
// Initialization
include_once 'include/init.php';

// Page title
$admin_title = 'Themes';

$themes = new themes();
$theme_list = $themes->get_theme_list();

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
								<div class="panel panel-default">
									<div class="panel-body">
										<img src="<?php echo $info['preview']; ?>" alt="<?php echo $info['name']; ?>" class="img-responsive">
										<ul class="list-group">
											<li class="list-group-item"><strong>Name:</strong> <?php echo $info['name']; ?></li>
											<li class="list-group-item"><strong>Author:</strong> <?php echo $info['author']; ?></li>
											<li class="list-group-item"><strong>Info:</strong> <?php echo $info['description']; ?></li>
										</ul>
										<a href="#" class="btn btn-info" title="Apply theme">Apply theme</a>
										<a href="#" class="btn btn-danger" title="Delete theme"><i class="fa fa-trash-o"></i></a>
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