<?php 
// Initialization
include_once 'include/init.php';

// Page title
$admin_title = 'Settings';

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
				<form action="<?php echo get_actual_url(false); ?>" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
					<div class="tc-tabs"><!-- Nav tabs style 5 -->
						<ul class="nav nav-tabs tab-lg-button tab-color-dark background-dark">
							<li class="active"><a href="#general" data-toggle="tab"><i class="fa fa-wrench bigger-130"></i> General</a></li>
							<li><a href="#media" data-toggle="tab"><i class="fa fa-camera bigger-130"></i> Media</a></li>
							<li><a href="#catalog" data-toggle="tab"><i class="fa fa-shopping-cart bigger-130"></i> Catelog</a></li>
							<li class="pull-right"><input type="submit" value="Submit" class="btn btn-primary"></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div class="tab-pane active" id="general">
								<div class="row">
									<div class="col-sm-6 col-xs-12">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Title') ?>:</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="" name="title">
												<p class="help-block"><?php __('Main title of your website') ?></p>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Description') ?>:</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="" name="description">
												<p class="help-block"><?php __('Sort description of your site') ?></p>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Site address') ?>:</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="" name="address">
												<p class="help-block"><?php __('Enter URL of your website') ?></p>
											</div>
										</div>
									</div><!-- // columns -->
								</div>
							</div><!-- // Ganeral -->
							<div class="tab-pane" id="media">
								Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.
							</div><!-- // media -->
							<div class="tab-pane" id="catalog">
								Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.
							</div><!-- catalog -->
						</div>
					</div><!--nav-tabs style 5-->
				</form>
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>