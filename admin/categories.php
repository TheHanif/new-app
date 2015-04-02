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
}

// Get all categories
$all_categories = $Categories->get_categories($type);

// Header file
include 'include/header.php';
?>
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
					<h1><?php echo __($admin_title); ?> <span class="sub-title"><?php __(ucfirst($type)); ?></span></h1>								
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
										<option value="0">Mustard</option>
										<option value="1">Ketchup</option>
										<option value="2">Relish</option>
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
				if (!isset($all_categories) || (isset($all_categories) && count($all_categories) <= 1)):
					echo "<p>";
					__($admin_title);
					echo " ";
					__("are not available.");
					echo "</p>";
				else:
				?>
				<table class="table table-bordered table-hover tc-table">
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
						<?php foreach ($all_categories as $key => $category) { ?>
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
									<a href="" class="btn btn-danger" onClick="return confirm('<?php __('Confirm delete?'); ?>');"><i class="fa fa-times icon-only"></i></a>
								</div>	
							</td>
						</tr>
						<?php } ?>
						<tr>
							<td></td>
							<td><i class="fa fa-minus text-gray"></i> <i class="fa fa-minus text-gray"></i> Sub category</td>
							<td class="col-small center"><span class="badge">10</span></td>
							<td class="col-medium">Fate</td>
							<td class="col-small center">
								<div class="btn-group btn-group-xs">
									<a href="" class="btn btn-inverse"><i class="fa fa-pencil icon-only"></i></a>
									<a href="" class="btn btn-danger" onClick="return confirm('<?php __('Confirm delete?'); ?>');"><i class="fa fa-times icon-only"></i></a>
								</div>	
							</td>
						</tr>
					</tbody>
				</table>	
				<?php endif; ?>
			</div>
			<!-- END YOUR CONTENT HERE -->
		</div>
<?php include 'include/footer.php'; ?>
<script src="assets/js/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script>
	$('.selectpicker').selectpicker('show');
</script>