<?php 
// Initialization
include_once 'include/init.php';

// Get status for form submission
$is_allowed = is_allowed(NULL, array('Settings'=>array('manage-settings')));

// Settings object
$Settings = new settings();

// Proccess submited data
if (isset($_POST['submit']) && $is_allowed) {
	unset($_POST['submit']);
	
	$state = 0;
	foreach ($_POST as $key => $value) {
		$state = $Settings->set_setting($key, $value);
	}

	if($state > 0){
		register_admin_message('Success', 'Your settings has been updated successfully.', 'success');
	}
	
	// reload language	
	$lang->__construct();
}

// Page title
$admin_title = 'Settings';

// Header file
include 'include/header.php';
?>
<!-- PAGE LEVEL PLUGINS STYLES -->
<link href="assets/css/plugins/select2/select2.css" rel="stylesheet">
<link href="assets/css/plugins/select2/select2.custom.min.css" rel="stylesheet">
<link href="assets/css/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
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
							<li class="active"><a href="#general" data-toggle="tab"><i class="fa fa-wrench bigger-130"></i> <?php __('General') ?></a></li>
							<li><a href="#media" data-toggle="tab"><i class="fa fa-camera bigger-130"></i> <?php __('Media') ?></a></li>
							<li><a href="#catalog" data-toggle="tab"><i class="fa fa-shopping-cart bigger-130"></i> <?php __('Catelog') ?></a></li>
							<li class="pull-right"><input type="submit" name="submit" value="<?php __('Submit') ?>" class="btn btn-primary"></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div class="tab-pane active" id="general">
								<div class="row">
									<div class="col-sm-6 col-xs-12">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Title') ?>:</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="<?php echo ($Settings->get_settings('site_title'))? $Settings->get_settings('site_title') : '' ?>" name="site_title">
												<p class="help-block"><?php __('Main title of your website') ?></p>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Description') ?>:</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="<?php echo ($Settings->get_settings('site_description'))? $Settings->get_settings('site_description') : '' ?>" name="site_description">
												<p class="help-block"><?php __('Sort description of your site') ?></p>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Site address') ?>:</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="<?php echo ($Settings->get_settings('site_url'))? $Settings->get_settings('site_url') : '' ?>" name="site_url">
												<p class="help-block"><?php __('Enter URL of your website') ?></p>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Email') ?>:</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" value="<?php echo ($Settings->get_settings('site_email'))? $Settings->get_settings('site_email') : '' ?>" name="site_email">
												<p class="help-block"><?php __('This address is used for admin purposes, like new user notification.') ?></p>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Language') ?>:</label>
											<div class="col-sm-9">
												<select name="language" class="selectpicker form-control" id="language">
													<?php 
														$languages = $lang->list_languages();
														foreach ($languages as $key => $data) {
															?>
																<option value="<?php echo $key; ?>" <?php echo ($Settings->get_settings('language') == $key)? 'selected' : '' ?>><?php echo $data['name']; ?> - <?php echo $data['country']; ?></option>
															<?php
														}
													?>
												</select>
												<p class="help-block"><?php __('Change admin language.') ?></p>
											</div>
										</div>

									</div><!-- // columns -->
								</div>
							</div><!-- // Ganeral -->
							<div class="tab-pane" id="media">
								<?php $media = ($Settings->get_settings('media'))? json_decode($Settings->get_settings('media')) : NULL ; ?>
								<h3><?php __('Image sizes') ?></h3>
								<p><?php __('The sizes listed below determine the maximum dimensions in pixels to use when adding an image to the Media.'); ?></p>
								<div class="hr hr-12 hr-double"></div>
								<div class="row">
									<div class="col-sm-6 col-xs-12">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Thumbnail') ?>:</label>
											
											<div class="col-sm-8 col-sm-offset-1">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="col-sm-4 control-label"><small><?php __('Width') ?>:</small></label>
															<div class="col-sm-6">
																<input type="text" class="form-control" value="<?php echo (isset($media->thumbnail->w))? $media->thumbnail->w : '' ?>" name="media[thumbnail][w]">
															</div>
														</div>
													</div><!-- width -->

													<div class="col-sm-6">
														<div class="form-group">
															<label class="col-sm-4 control-label"><small><?php __('Height') ?>:</small></label>
															<div class="col-sm-6">
																<input type="text" class="form-control" value="<?php echo (isset($media->thumbnail->h))? $media->thumbnail->h : '' ?>" name="media[thumbnail][h]">
															</div>
														</div>
													</div><!-- height -->
												</div>
												<div class="tcb">
													<label>
														<input type="checkbox" class="tc" <?php echo (isset($media->thumbnail->c))? 'checked' : '' ?> name="media[thumbnail][c]" value="1">
														<span class="labels"> <?php __('Crop thumbnail to exact dimensions'); ?></span>
													</label>
												</div><!-- // crop checkbox -->
											</div><!-- column -->

										</div><!-- // thumbnail -->

										<hr class="seperator">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Small') ?>:</label>
											
											<div class="col-sm-8 col-sm-offset-1">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="col-sm-4 control-label"><small><?php __('Width') ?>:</small></label>
															<div class="col-sm-6">
																<input type="text" class="form-control" value="<?php echo (isset($media->small->w))? $media->small->w : '' ?>" name="media[small][w]">
															</div>
														</div>
													</div><!-- width -->

													<div class="col-sm-6">
														<div class="form-group">
															<label class="col-sm-4 control-label"><small><?php __('Height') ?>:</small></label>
															<div class="col-sm-6">
																<input type="text" class="form-control" value="<?php echo (isset($media->small->h))? $media->small->h : '' ?>" name="media[small][h]">
															</div>
														</div>
													</div><!-- height -->
												</div>

												
											</div><!-- column -->

										</div><!-- // small -->
										
										<hr class="seperator">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Medium') ?>:</label>
											
											<div class="col-sm-8 col-sm-offset-1">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="col-sm-4 control-label"><small><?php __('Width') ?>:</small></label>
															<div class="col-sm-6">
																<input type="text" class="form-control" value="<?php echo (isset($media->medium->w))? $media->medium->w : '' ?>" name="media[medium][w]">
															</div>
														</div>
													</div><!-- width -->

													<div class="col-sm-6">
														<div class="form-group">
															<label class="col-sm-4 control-label"><small><?php __('Height') ?>:</small></label>
															<div class="col-sm-6">
																<input type="text" class="form-control" value="<?php echo (isset($media->medium->h))? $media->medium->h : '' ?>" name="media[medium][h]">
															</div>
														</div>
													</div><!-- height -->
												</div>
												
											</div><!-- column -->

										</div><!-- // Medium -->

										<hr class="seperator">
										<div class="form-group">
											<label class="col-sm-3 control-label"><?php __('Large') ?>:</label>
											
											<div class="col-sm-8 col-sm-offset-1">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label class="col-sm-4 control-label"><small><?php __('Width') ?>:</small></label>
															<div class="col-sm-6">
																<input type="text" class="form-control" value="<?php echo (isset($media->large->w))? $media->large->w : '' ?>" name="media[large][w]">
															</div>
														</div>
													</div><!-- width -->

													<div class="col-sm-6">
														<div class="form-group">
															<label class="col-sm-4 control-label"><small><?php __('Height') ?>:</small></label>
															<div class="col-sm-6">
																<input type="text" class="form-control" value="<?php echo (isset($media->large->h))? $media->large->h : '' ?>" name="media[large][h]">
															</div>
														</div>
													</div><!-- height -->
												</div>
												
											</div><!-- column -->

										</div><!-- // Large -->

									</div>
								</div><!-- // row -->
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
<script src="assets/js/plugins/select2/select2.min.js"></script>
<script src="assets/js/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script type="text/javaScript">
	$(document).ready(function() {
		$('.selectpicker').selectpicker('show');
	});
</script>