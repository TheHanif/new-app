<?php 
// Initialization
include_once 'include/init.php';

// Page title
$admin_title = 'Categories';

// Get type for custom post
$type = $_GET['type'];

$ID = (isset($_GET['ID']))? $_GET['ID'] : NULL;

$Categories = new categories();

if (isset($_POST['submit'])) {
	$result = $Categories->save_category($_POST, $type, $ID);
	if ($result > 0) {
		register_admin_message('Success', 'Category updated/created successfully.', 'success');
	}
}

if (isset($_GET['action'])) {
	
	// Get category
	if ($_GET['action'] == 'edit') {
		$category = $Categories->get_categories($type, $ID);
	}

	// Delete category
	if ($_GET['action'] == 'delete') {
		if ($Categories->delete_category($ID) > 0) {
			register_admin_message('Success', 'Category has been deleted successfully.', 'success');
		}else{
			register_admin_message('Not found', 'Category not found or already deleted. Please try again.', 'danger');
		}
		unset($_GET['action']);
		unset($_GET['ID']);
	}
}

// Get all categories
$all_categories = $Categories->get_categories($type);

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
					<h1><?php echo __($admin_title); ?> <span class="sub-title"><?php __(ucfirst($type)); ?></span> <?php if (isset($_GET['action']) && $_GET['action'] == 'edit') {
						?> <a href="categories.php?type=<?php echo $type; ?>" class="btn btn-default pull-right btn-sm"><i class="fa fa-plus"></i> <?php __('Create new'); ?></a><?php
					} ?></h1>								
				</div>
				
				<?php get_messages(); ?>	

			</div><!-- /.col-lg-12 -->
		</div><!-- /.row -->
	<!-- END PAGE HEADING ROW -->

		<?php
		// Check page for loack status
		get_lock_status(); ?>
		
		<div class="row">
			<!-- START YOUR CONTENT HERE -->
			<div class="col-md-5">
				<div class="portlet">
					<div class="portlet-heading default-bg">
						<div class="portlet-title">
							<h4><?php __(((isset($_GET['action']) && $_GET['action'] == 'edit')? 'Edit' : 'Create new')); echo ' '; __('category'); ?></h4>
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="portlet-body">
						<form class="form-horizontal" action="<?php echo get_actual_url(false); ?>" role="form" method="post">
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php __('Name'); ?></label>
								<div class="col-sm-10">
									<input type="text" name="name" value="<?php echo (isset($category))? $category->category_name : ''; ?>" class="form-control" id="name">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php __('Slug'); ?></label>
								<div class="col-sm-10">
									<input type="text" disabled value="<?php echo (isset($category))? $category->category_slug : ''; ?>" name="slug" id="slug" class="form-control input-sm">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php __('Parent'); ?></label>
								<div class="col-sm-10">
									<select name="parent" class="form-control selectpicker">
										<option value="">None</option>
										<?php foreach ($all_categories as $key => $all_category) { 
												if(isset($category) && $all_category->category_id == $category->category_id) continue;
												if($all_category->category_parent != 0) continue;
											?>
										<option value="<?php echo $all_category->category_id; ?>" <?php echo (isset($category) && $all_category->category_id == $category->category_parent)? 'selected' : ''; ?>><?php echo $all_category->category_name; ?></option>

											<!-- Go for sencond level -->
												<?php foreach ($all_categories as $key => $second_all_category) { 
														if(isset($category) && $second_all_category->category_id == $category->category_id) continue;
														if($second_all_category->category_parent != $all_category->category_id) continue;
													?>
												<option value="<?php echo $second_all_category->category_id; ?>" <?php echo (isset($category) && $second_all_category->category_id == $category->category_parent)? 'selected' : ''; ?>>- <?php echo $second_all_category->category_name; ?></option>

													<!-- Go for third level -->
														<!--<?php foreach ($all_categories as $key => $third_all_category) { 
																if(isset($category) && $third_all_category->category_id == $category->category_id) continue;
																if($third_all_category->category_parent != $second_all_category->category_id) continue;
															?>
														<option value="<?php echo $third_all_category->category_id; ?>" <?php echo (isset($category) && $third_all_category->category_id == $category->category_parent)? 'selected' : ''; ?>>-- <?php echo $third_all_category->category_name; ?></option>
														<?php }?>-->
													<!-- End of third level -->

												<?php }?>
											<!-- End of sencond level -->

										<?php } // end of first level ?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php __('Image'); ?></label>
								<div class="col-sm-10">
									<div class="input-group">
										<div id="thumbnail">
											<?php if (isset($category) && (!empty($category->category_media) && $Categories->Media->get_media($category->category_media))) {
												$media = $Categories->Media->get_media($category->category_media);
												echo '<img src="'.$media[0]->thumbnail.'">';
											} ?>
										</div>
										<span class="btn btn-file1 browse-media" data-media="<?php echo (isset($category) && !empty($category->category_media))? 1 : 0; ?>" data-preview="#preview" data-thumbnail="#thumbnail" data-value="#image" data-output="id">
											<?php __((isset($category) && !empty($category->category_media))? 'Remove' : 'Browse'); ?>
										</span>
										<input type="hidden" name="image" value="<?php echo (isset($category))? $category->category_media : ''; ?>" id="image"  class="form-control">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php __('Order'); ?></label>
								<div class="col-sm-2">
									<input type="text" name="order" value="<?php echo (isset($category))? $category->category_order : ''; ?>" class="form-control input-sm">
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-sm-12">
									<textarea name="description" rows='6' placeholder="<?php __('Category Description'); ?>" id="editor" class="form-control"><?php echo (isset($category))? $category->category_description : ''; ?></textarea>
								</div>
							</div>

							<div class="form-actions">
								<div class="form-group">
									<div class="col-sm-12">
										<button type="submit" name='submit' value='submit' class="btn btn-primary"><?php __('Submit'); ?></button>
										<a href="categories.php?type=<?php echo $type; ?>" class="btn btn-inverse"><?php __('Cancel') ?></a>
									</div>
								</div>
							</div>
						</form>
					</div>

				</div><!-- end of .portlet -->
			</div><!-- end of form -->
			<div class="col-md-7">
				<?php
				// print_f($all_categories);
				if (!isset($all_categories)):
					echo "<p>";
					__($admin_title);
					echo " ";
					__("are not available.");
					echo "</p>";
				else:
				?>
				<table class="table table-bordered table-striped table-hover tc-table">
					<thead>
						<tr>
							<th class="col-small center"><?php __('Image'); ?></th>
							<th><?php __('Name') ?></th>
							<th class="col-small"><?php __('Posts') ?></th>
							<th class="hidden-xs col-medium"><?php __('Date') ?></th>
							<th class="center col-small"><?php __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($all_categories as $key => $category) { 
								if($category->category_parent != 0) continue;
							?>
						<tr>
							<td>
								<?php if (!empty($category->category_media) && $Categories->Media->get_media($category->category_media)) {
										$media = $Categories->Media->get_media($category->category_media);
										echo '<img src="'.$media[0]->thumbnail.'" style="width:100%">';
									} ?>
							</td>
							<td><?php echo $category->category_name; ?></td>
							<td class="col-small center"><span class="badge"><?php echo (empty($category->category_item_count))? 0 : $category->category_item_count; ?></span></td>
							<td class="col-medium"><?php echo $Categories->_date('d-m-Y', $category->category_ts); ?></td>
							<td class="col-small center">
								<div class="btn-group btn-group-xs">
									<a href="categories.php?type=<?php echo $type; ?>&action=edit&ID=<?php echo $category->category_id; ?>" class="btn btn-inverse"><i class="fa fa-pencil icon-only"></i></a>
									<a href="categories.php?type=<?php echo $type; ?>&action=delete&ID=<?php echo $category->category_id; ?>" class="btn btn-danger" onClick="return confirm('<?php __('Confirm delete?'); ?>');"><i class="fa fa-times icon-only"></i></a>
								</div>	
							</td>
						</tr>
								
							<!-- Go for second level -->
								<?php foreach ($all_categories as $second_key => $second_category) { 
										if($category->category_id != $second_category->category_parent) continue;
									?>
									<tr>
										<td>
											<?php if (!empty($second_category->category_media) && $Categories->Media->get_media($second_category->category_media)) {
													$media = $Categories->Media->get_media($second_category->category_media);
													echo '<img src="'.$media[0]->thumbnail.'" style="width:100%">';
												} ?>
										</td>
										<td><i class="fa fa-minus text-gray"></i> <?php echo $second_category->category_name; ?></td>
										<td class="col-small center"><span class="badge"><?php echo (empty($second_category->category_item_count))? 0 : $second_category->category_item_count; ?></span></td>
										<td class="col-medium"><?php echo $Categories->_date('d-m-Y', $second_category->category_ts); ?></td>
										<td class="col-small center">
											<div class="btn-group btn-group-xs">
												<a href="categories.php?type=<?php echo $type; ?>&action=edit&ID=<?php echo $second_category->category_id; ?>" class="btn btn-inverse"><i class="fa fa-pencil icon-only"></i></a>
												<a href="categories.php?type=<?php echo $type; ?>&action=delete&ID=<?php echo $second_category->category_id; ?>" class="btn btn-danger" onClick="return confirm('<?php __('Confirm delete?'); ?>');"><i class="fa fa-times icon-only"></i></a>
											</div>	
										</td>
									</tr>

									<!-- Go for third level -->
										<?php foreach ($all_categories as $third_key => $third_category) { 
												if($second_category->category_id != $third_category->category_parent) continue;
											?>
											<tr>
												<td>
													<?php if (!empty($third_category->category_media) && $Categories->Media->get_media($third_category->category_media)) {
															$media = $Categories->Media->get_media($third_category->category_media);
															echo '<img src="'.$media[0]->thumbnail.'" style="width:100%">';
														} ?>
												</td>
												<td><i class="fa fa-minus text-gray"></i> <i class="fa fa-minus text-gray"></i> <?php echo $third_category->category_name; ?></td>
												<td class="col-small center"><span class="badge"><?php echo (empty($third_category->category_item_count))? 0 : $third_category->category_item_count; ?></span></td>
												<td class="col-medium"><?php echo $Categories->_date('d-m-Y', $third_category->category_ts); ?></td>
												<td class="col-small center">
													<div class="btn-group btn-group-xs">
														<a href="categories.php?type=<?php echo $type; ?>&action=edit&ID=<?php echo $third_category->category_id; ?>" class="btn btn-inverse"><i class="fa fa-pencil icon-only"></i></a>
														<a href="categories.php?type=<?php echo $type; ?>&action=delete&ID=<?php echo $third_category->category_id; ?>" class="btn btn-danger" onClick="return confirm('<?php __('Confirm delete?'); ?>');"><i class="fa fa-times icon-only"></i></a>
													</div>	
												</td>
											</tr>
										<?php } ?>
									<!-- End third level -->

								<?php } ?>
							<!-- End second level -->

						<?php } // End first level ?>
						
					</tbody>
				</table>	
				<?php endif; ?>
			</div>
			<!-- END YOUR CONTENT HERE -->
		</div>
<?php include 'include/footer.php'; ?>