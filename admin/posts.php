<?php 
// Initialization
include_once 'include/init.php';

// Get type for custom post
$type = $_GET['type'];

// Get data of custom post from global post container
$custom_post = $posts[$type];
$custom_name = $custom_post['meta']['single_title'];
$custom_names = $custom_post['meta']['pulural_title'];

$Posts = new post();

// Change status
if (isset($_GET['change']) && isset($_GET['ID'])) {
	$post = $Posts->get_post($_GET['ID']);

	$status = 'published';

	if ($post->status == 'published') {
		$status = 'unpublished';
	}

	$Posts->change_status($_GET['ID'], $status);
	register_admin_message('Success', ucfirst($status).' successfully.', 'success');
}

// Change status
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
	if (isset($_GET['permanent'])) {
		$state = $Posts->delete_post($_GET['ID']);
	}else{
		$state = $Posts->change_status($_GET['ID'], 'deleted');
	}
	
	if ($state) {
		register_admin_message('Success', 'Deleted successfully.', 'success');
	}else{
		register_admin_message('Not found', ucfirst($custom_name).' not found or already deleted. Please try again.', 'danger');
	}
}

// Action
if (isset($_POST['submit'])) {
	foreach ($_POST['posts'] as $ID) {
		if($_POST['action'] == 'deleted'){
			$post = $Posts->get_post($ID);

			if ($Posts->row_count() > 0 && $post->status == 'deleted') {
				$Posts->delete_post($ID);
			}elseif($Posts->row_count() > 0){
				$state = $Posts->change_status($ID, 'deleted');
			}

		}else{
			$Posts->change_status($ID, $_POST['action']);
		}
	}

	register_admin_message('Success', 'Action applied successfully.', 'success');
}

// Select all post
$fields = array();
$fields['ID'] = 'ID';
$fields['author'] = 'author';
$fields['title'] = 'title';
$fields['parent'] = 'parent';
$fields['comments'] = 'comments';
$fields['status'] = 'status';
$fields['ts'] = 'cts';
$fields['modified_ts'] = 'mts';


// Filter by category
if (isset($_POST['filter']) || isset($_GET['category'])) {

	$category = (isset($_POST['category'])) ? $_POST['category'] : $_GET['category'];

	if(!empty($category)){
		$Posts->inner_join('meta', 'c', 'c.object_id = objects.ID');
		$Posts->where('c.meta_key', 'category');
		$Posts->where('c.meta_value', $category);
	}
} // end filter

if (isset($_GET['status'])) {
	$Posts->where('status', $_GET['status']);
}

$Posts->select($fields);
$all_posts = $Posts->get_posts($type);
// print_f($all_posts, 1);

// Page title
$admin_title = ucfirst($custom_names);

// Header file
include 'include/header.php';
?>
<link rel="stylesheet" href="assets/css/plugins/footable/footable.min.css">
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
		
		<!-- START YOUR CONTENT HERE -->
		<form action="" method="post">
			<div class="row">
				<div class="col-lg-12">
					
					<div class="well white">
						<div class="row">
							<div class="col-sm-5">
								<a href="posts.php?type=<?php echo $type; ?>" class="btn btn-sm <?php echo (!isset($_GET['status']))? 'btn-primary active disabled' : ''; ?>">All <small class="badge <?php echo (!isset($_GET['status']))? 'badge-inverse' : 'badge-primary'; ?>"><?php echo $Posts->get_post_count($type); ?></small></a>
								<a href="posts.php?type=<?php echo $type; ?>&status=published" class="btn btn-sm <?php echo (isset($_GET['status']) && $_GET['status'] == 'published')? 'btn-primary active disabled' : ''; ?>">Published <small class="badge <?php echo (isset($_GET['status']) && $_GET['status'] == 'published')? 'badge-inverse' : 'badge-primary'; ?>"><?php echo $Posts->get_post_count($type, 'published'); ?></small></a>
								<a href="posts.php?type=<?php echo $type; ?>&status=unpublished" class="btn btn-sm <?php echo (isset($_GET['status']) && $_GET['status'] == 'unpublished')? 'btn-primary active disabled' : ''; ?>">Unpublished <small class="badge <?php echo (isset($_GET['status']) && $_GET['status'] == 'unpublished')? 'badge-inverse' : 'badge-primary'; ?>"><?php echo $Posts->get_post_count($type, 'unpublished'); ?></small></a>
								<a href="posts.php?type=<?php echo $type; ?>&status=deleted" class="btn btn-sm <?php echo (isset($_GET['status']) && $_GET['status'] == 'deleted')? 'btn-primary active disabled' : ''; ?>">Trash <small class="badge <?php echo (isset($_GET['status']) && $_GET['status'] == 'deleted')? 'badge-inverse' : 'badge-primary'; ?>"><?php echo $Posts->get_post_count($type, 'deleted'); ?></small></a>
							</div>
							<div class="col-sm-4">
								<div class="form-horizontal">
									<div class="form-group" style="margin-bottom:0">
										<label class="col-sm-3 control-label"><?php __('Category'); ?>:</label>
										<div class="col-sm-6">
											<select name="category" class="form-control selectpicker">
												<option value=""><?php __('All'); ?></option>
												<?php 
													$Categories = new categories();
													$all_categories = $Categories->get_categories($type);

													if ($all_categories) { 
														foreach ($all_categories as $category) { 
															$selected = (isset($_GET['category']) && $_GET['category'] == $category->category_id) ? 'selected' : '';
															$selected = (isset($_POST['category']) && $_POST['category'] == $category->category_id) ? 'selected' : $selected;
														?>
														<option <?php echo $selected; ?> value="<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></option>
												<?php }} ?>
											</select>
										</div>
										<div class="col-sm-3">
											<input type="submit" class="btn btn-default" value="<?php __('Filter'); ?>" name="filter">
										</div>
									</div>
								</div>
							</div><!-- // . col -->
							<div class="col-sm-3">
								<div class="form-horizontal">
									<div class="form-group" style="margin-bottom:0">
										<label class="col-sm-3 control-label"><?php __('Actions'); ?>:</label>
										<div class="col-sm-5">
											<select name="action" class="form-control selectpicker">
												<option value=""><?php __('None'); ?></option>
												<option value="published"><?php __('Publish'); ?></option>
												<option value="unpublished"><?php __('Un Publish'); ?></option>
												<option value="deleted"><?php __('Delete'); ?></option>
											</select>
										</div>
										<div class="col-sm-4">
											<input type="submit"  onClick="return confirm('<?php echo 'Do you realy want to apply this action?' ?>');" class="btn btn-default" value="<?php __('Apply'); ?>" name="submit">
										</div>
									</div>
								</div>
							</div><!-- // . col -->
						</div>
					</div><!-- // .well -->
					
					<?php
					// print_f($all_categories);
					if (!isset($all_posts) || empty($all_posts)):
						echo "<p>";
						__($admin_title);
						echo " ";
						__("are not available.");
						echo "</p>";
					else:
					?>
					
					<div class="well white">
						<table id="SampleDT" class="datatable table table-bordered table-striped table-hover tc-table table-primary footable">
							<thead>
								<tr>
									<th class="col-small center"><label><input type="checkbox" class="tc"><span class="labels"></span></label></th>
									<th><?php __('Name') ?></th>
									<th class="hidden-xs col-large center"><i class="fa fa-user" title="Author"></i></th>
									<th class="hidden-xs col-medium center"><i class="fa fa-comments" title="Post Comments"></i></th>
									<th class="hidden-xs col-medium center"><i class="fa fa-calendar" title="Date"></i></th>
									<th class="center col-medium"><?php __('Actions') ?></th>

								</tr>
							</thead>
							<tbody>

								<?php 
								
									function generate_parent($all_posts, $parent = NULL, $indent = '', $hierarchy = true){
										global $type;
										foreach ($all_posts as $post) {
											if ($hierarchy == true && $post->parent != $parent) {
												continue;
											}
											?>
												<tr>
													<td class="col-small center"><label><input type="checkbox" class="tc" name='posts[]' value="<?php echo $post->ID; ?>"><span class="labels"></span></label></td>
													<td><?php echo $indent.' '.$post->title ?></td>
													<td>
														<?php 
															// Author
															$Users = new users();
															$profile = $Users->get_profile($post->author);
															echo $profile->user_display_name;
														?>
													</td>
													<td class="col-medium center"><small class="badge center"><?php echo $post->comments; ?></small></td>
													<td class="col-medium center"><?php echo $Users->_date('d-m-Y', $post->cts); ?></td>
													<td class="center col-medium">
														<div class="btn-group btn-group-sm">
															<a href="post_create.php?type=<?php echo $type; ?>&ID=<?php echo $post->ID; ?>" class="btn btn-inverse"><i class="fa fa-pencil icon-only"></i></a>
															<a href="posts.php?type=<?php echo $type; ?>&change=status&ID=<?php echo $post->ID; ?>" class="btn" title="<?php echo ($post->status == 'published')? 'Unpublished' : 'Published'; ?>"><i class="fa fa-eye icon-only"></i></a>
															<a href="posts.php?type=<?php echo $type; ?>&action=delete&ID=<?php echo $post->ID; echo ($post->status == 'deleted')? '&permanent=true' : ''; ?>" class="btn btn-danger" onClick="return confirm('<?php __('Confirm '.(($post->status == 'deleted')? 'permanent ' : '').'delete?'); ?>');"><i class="fa fa-times icon-only"></i></a>
														</div>	
													</td>
												</tr>
											<?php
											if($hierarchy)
											generate_parent($all_posts, $post->ID, $indent.'<i class="fa fa-minus text-gray"></i> ', $hierarchy);
										}
									} // end of generate_parent()
									generate_parent($all_posts, 0, '', ((isset($_GET['status']))? false : true));
								?>

							</tbody>
						</table>
					</div><!-- end of .well -->

					<?php endif; ?>
				</div>
			</div>
		</form>
		<!-- END YOUR CONTENT HERE -->

<?php include 'include/footer.php'; ?>

<script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/js/plugins/datatables/datatables.js"></script>
<script src="assets/js/plugins/datatables/datatables.responsive.js"></script>
<script src="assets/js/plugins/datatables/datatables.init.js"></script>