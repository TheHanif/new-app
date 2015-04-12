<?php 
// Initialization
include_once 'include/init.php';

$ID = (isset($_GET['ID']))? $_GET['ID'] : NULL;

// Get type for custom post
$type = $_GET['type'];

$Post = new Post();
$Media = new Media();

if (isset($_POST['title'])) {
	
	$result = $Post->save_post($_POST, $ID, $type);
	if ($result > 0) {

		if (!isset($ID)) {
			$_SESSION['postback'] = true;
			header('Location:'.get_actual_url(false).'&ID='.$result);
			exit;
		}
		register_admin_message('Success', 'Post updated successfully.', 'success');
	}
}

if (isset($_SESSION['postback']) && $_SESSION['postback'] == true) {
	unset($_SESSION['postback']);
	register_admin_message('Success', 'Post created successfully.', 'success');
}

if (isset($ID)) {
	$post_data = $Post->get_post($ID);
}

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
						<input type="text" value="<?php echo (isset($ID))? $post_data->title : '' ?>" class="form-control input-lg" style="font-weight:bold;" id="name" name="title" placeholder="<?php echo ucfirst($custom_name).' '; __('name') ?>">
					</div><!-- Name -->

					<?php 
					// Post permalink
					if(isset($custom_post['permalink']) && $custom_post['permalink'] == true): ?>
					<div class="form-group input-group">
						<span class="input-group-addon"><i class="fa fa-link"></i></span>
						<span class="input-group-addon"><?php echo SITEURL; ?></span>
						<input type="text" value="<?php echo (isset($ID))? $post_data->name : '' ?>" class="form-control" id="slug" disabled name="slug">
						<a href="#" class="btn btn-default input-group-addon"><i class="fa fa-pencil"></i></a>
					</div><!-- permalink -->
					<?php endif; // end of post permalink ?>
					
					<?php 
					// Post content
					if(isset($custom_post['content']) && $custom_post['content'] == true): ?>
					<div class="portlet">
						<div class="portlet-heading default-bg">
							<div class="portlet-title">
								<h4><strong><?php echo ucfirst($custom_name); ?> <?php __('Contents'); ?></strong></h4>
							</div>
							<div class="portlet-widgets">
								<a data-toggle="collapse" data-parent="#accordion" href="#content"><i class="fa fa-chevron-down"></i></a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div id="content" class="panel-collapse collapse in">
							<div class="portlet-body">
								<div class="form-group">
									<textarea name="content" rows="20" id="editor" class="form-control"><?php echo (isset($ID))? $post_data->content : '' ?></textarea>
								</div>
							</div>
						</div>
					</div><!-- post contents -->
					<?php endif; // end of post content ?>

					<?php 
					// Post excerpt
					if(isset($custom_post['excerpt']) && $custom_post['excerpt'] == true): ?>
					<div class="portlet">
						<div class="portlet-heading default-bg">
							<div class="portlet-title">
								<h4><strong><?php __('Excerpt'); ?></strong></h4>
							</div>
							<div class="portlet-widgets">
								<a data-toggle="collapse" data-parent="#accordion" href="#excerpt"><i class="fa fa-chevron-down"></i></a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div id="excerpt" class="panel-collapse collapse in">
							<div class="portlet-body">
								<div class="form-group">
									<textarea name="excerpt" rows="7" class="form-control"><?php echo (isset($ID))? $post_data->excerpt : '' ?></textarea>
								</div>
							</div>
						</div>
					</div><!-- post contents -->
					<?php endif; // end of post excerpt ?>



				</div><!-- end of main contents -->
				
				<!-- Sidebar start -->
				<div class="col-md-3">
					<div class="portlet">
						<div class="portlet-heading default-bg">
							<div class="portlet-title">
								<h4><strong><?php __('Attributes'); ?></strong></h4>
							</div>
							<div class="portlet-widgets">
								<a data-toggle="collapse" data-parent="#accordion" href="#attributes"><i class="fa fa-chevron-down"></i></a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div id="attributes" class="panel-collapse collapse in">
							<div class="portlet-body">

								<?php 
								// Post template
								if (isset($custom_post['attributes']) && in_array('template', $custom_post['attributes'])): ?>
								<div class="form-horizontal">
									<div class="form-group">
										<label class="col-sm-3 control-label"><?php __('Template') ?></label>
										<div class="col-sm-9">
											<select name="template" class="form-control selectpicker">
												<option><?php __('none'); ?></option>
												<option value="default" <?php echo ($Post->get_meta($ID, 'template'))? 'selected' : '' ?>>Default</option>
											</select>
										</div>
									</div>
								</div>
								<?php endif; // end of post template ?>

								<?php 
								// Post parent
								if (isset($custom_post['attributes']) && in_array('parent', $custom_post['attributes'])): ?>
								<div class="form-horizontal">
									<div class="form-group">
										<label class="col-sm-3 control-label"><?php __('Parent') ?></label>
										<div class="col-sm-9">
											<select name="parent" class="form-control selectpicker">
												<option><?php __('none'); ?></option>
												<option value="5" <?php echo (isset($ID) && $post_data->parent == '5')? 'selected' : '' ?>>5</option>
											</select>
										</div>
									</div>
								</div>
								<?php endif; // end of post parent ?>

								<?php 
								// Post sidebar
								if (isset($custom_post['attributes']) && in_array('sidebar', $custom_post['attributes'])): ?>
								<div class="form-horizontal">
									<div class="form-group">
										<label class="col-sm-3 control-label"><?php __('Sidebar') ?></label>
										<div class="col-sm-9">
											<select name="sidebar" class="form-control selectpicker">
												<option><?php __('none'); ?></option>
												<option value="left" <?php echo ($Post->get_meta($ID, 'sidebar'))? 'selected' : '' ?>>left</option>
											</select>
										</div>
									</div>
								</div>
								<?php endif; // end of post sidebar ?>
								
								<?php 
								// Seperator
								echo (isset($custom_post['attributes']) && count($custom_post['attributes']) > 0)? '<hr>' : ''; ?>

								<div class="form-group" style="margin-bottom:0">
									<div class="row">
										<div class="col-md-8">
											<?php if(isset($ID)): ?>
												<label title="<?php __('Duplicate') ?>" style="margin-top:5px; margin-bottom:0"><strong style="margin-top:2px; float:left"><?php __('Duplicate') ?> </strong>
													<input name="duplicate" class="tc tc-switch tc-switch-5" value="1" type="checkbox" />
													<span class="labels"></span>
												</label>
											<?php endif; ?>
										</div>
										<div class="col-md-4">
											<input type="submit" value="<?php __('Save') ?>" class="btn btn-primary pull-right">
										</div>
									</div>
								</div><!-- // form-group -->
							</div><!-- // portlet-body -->
						</div>
					</div><!-- end of attributes -->

					<?php 
					// Categories
					if(isset($custom_post['category']) && $custom_post['category'] == true): ?>
					<div class="portlet">
						<div class="portlet-heading default-bg">
							<div class="portlet-title">
								<h4><strong><?php __('Categories'); ?></strong></h4>
							</div>
							<div class="portlet-widgets">
								<a data-toggle="collapse" data-parent="#accordion" href="#categories"><i class="fa fa-chevron-down"></i></a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div id="categories" class="panel-collapse collapse in">
							<div class="portlet-body">
									<?php 
										$selected_categories = array();

										if (isset($ID)) {
											unset($selected_categories);
											$selected_categories = json_decode($Post->get_meta($ID, 'categories'));
										}

										// Get all categories
										$Categories = new categories();
										$all_categories = $Categories->get_categories($type);
										foreach ($all_categories as $key => $all_category) { 
											if($all_category->category_parent != 0) continue;
										?>
										<div class="row">
										<div class="col-xs-12">
										<div class="tcb" style="margin:0">
											<label>
												<input name="categories[]" <?php echo (in_array($all_category->category_id, $selected_categories))? 'checked' : '' ?> value="<?php echo $all_category->category_id; ?>" type="checkbox" class="tc">
												<span class="labels"> <?php echo $all_category->category_name; ?></span>
											</label>
										</div></div></div>

											<!-- Go for sencond level -->
											<?php foreach ($all_categories as $key => $second_all_category) { 
													if($second_all_category->category_parent != $all_category->category_id) continue;
												?>
											<div class="row"><div class="col-xs-1"></div>
											<div class="col-xs-11">
											<div class="tcb" style="margin:0">
												<label>
													<input name="categories[]" <?php echo (in_array($second_all_category->category_id, $selected_categories))? 'checked' : '' ?> value="<?php echo $second_all_category->category_id; ?>" type="checkbox" class="tc">
													<span class="labels"> <?php echo $second_all_category->category_name; ?></span>
												</label>
											</div></div></div>

												<!-- Go for third level -->
												<?php foreach ($all_categories as $key => $third_all_category) { 
														if($third_all_category->category_parent != $second_all_category->category_id) continue;
													?>
												<div class="row"><div class="col-xs-2"></div>
												<div class="col-xs-10">
												<div class="tcb" style="margin:0">
													<label>
														<input name="categories[]" <?php echo (in_array($third_all_category->category_id, $selected_categories))? 'checked' : '' ?> value="<?php echo $third_all_category->category_id; ?>" type="checkbox" class="tc">
														<span class="labels"> <?php echo $third_all_category->category_name; ?></span>
													</label>
												</div></div></div>
												
												<?php }?>
												<!-- End of third level -->

											<?php }?>
											<!-- End of sencond level -->

									<?php } // end of first level ?>
							</div><!-- end of .body -->
						</div>
					</div><!-- end of .portlet -->
					<?php endif; // end of categories ?>

					<?php 
					// Featured images
					if(isset($custom_post['featured_image']) && (is_numeric($custom_post['featured_image']) && $custom_post['featured_image'] > 0)):

						$selected_media = array();

						if (isset($ID)) {
							$selected_media = json_decode($Post->get_meta($ID, 'featured_image'));
						}

						for ($i=0; $i < $custom_post['featured_image']; $i++):
							$fortlet_id = ($custom_post['featured_image'] > 1)? 'Featured Image '.($i+1) : 'Featured Image';

							$media = '';
							if (isset($selected_media[$i]) && !empty($selected_media[$i])) {
								$media = $Media->get_media($selected_media[$i]);
								$media = $media[0];
							}
						?>
						<div class="portlet">
							<div class="portlet-heading default-bg">
								<div class="portlet-title">
									<h4><strong><?php __($fortlet_id); ?></strong></h4>
								</div>
								<div class="portlet-widgets">
									<a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $fortlet_id; ?>"><i class="fa fa-chevron-down"></i></a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div id="<?php echo $fortlet_id; ?>" class="panel-collapse collapse in">
								<div class="portlet-body">
									<div class="thumbnail<?php echo $i; ?>"><?php echo (isset($selected_media[$i]) && !empty($selected_media[$i]) && isset($media->ID))? ('<img src="'.$media->thumbnail.'">') : ''; ?></div>
									<span class="btn btn-file1 browse-media" data-media="<?php echo (isset($selected_media[$i]) && !empty($selected_media[$i]) && isset($media->ID))? 1 : 0; ?>" data-thumbnail=".thumbnail<?php echo $i; ?>" data-value=".value<?php echo $i; ?>" data-output="id">
										<?php echo (isset($selected_media[$i]) && !empty($selected_media[$i]) && isset($media->ID))? 'Remove' : 'Browse'; ?>
									</span>
									<input type="hidden" class="value<?php echo $i; ?>" value="<?php echo (isset($selected_media[$i]) && !empty($selected_media[$i]) && isset($media->ID))? $media->ID : ''; ?>" name="featured_image[<?php echo $i; ?>]">
								</div><!-- end body -->
							</div>
						</div><!-- end portlet -->
					<?php 
						endfor;
					endif; ?>
				</div><!-- end of sidebar -->
			</form>
		</div>
		<!-- END YOUR CONTENT HERE -->
<?php include 'include/footer.php'; ?>
<script>
	$('#categories').find('.portlet-body').slimScroll({
		height: '200px',
		disableFadeOut: true,
		touchScrollStep: 50
	});
</script>


