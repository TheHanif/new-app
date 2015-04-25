<?php 
// Initialization
include_once 'include/init.php';

// Get type for custom post
$type = $_GET['type'];

$Posts = new post();

// Select all post
$fields = array();
$fields['ID'] = 'ID';
$fields['author'] = 'author';
$fields['title'] = 'title';
$fields['parent'] = 'parent';
$fields['ts'] = 'cts';
$fields['modified_ts'] = 'mts';

$Posts->select($fields);
$all_posts = $Posts->get_posts($type);

// Get data of custom post from global post container
$custom_post = $posts[$type];
$custom_name = $custom_post['meta']['single_title'];
$custom_names = $custom_post['meta']['pulural_title'];

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
		<div class="row">
			<div class="col-lg-12">
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
					<a href="#" class="btn btn-sm">All <small class="badge badge-primary">59</small></a>
					<a href="#" class="btn btn-sm btn-primary active disabled">Published <small class="badge badge-inverse">41</small></a>
					<a href="#" class="btn btn-sm ">Unpublished <small class="badge badge-primary">8</small></a>
					<a href="#" class="btn btn-sm ">Trash <small class="badge badge-primary">10</small></a>

					
				</div>

				<div class="well white">
					<table id="SampleDT" class="datatable table table-bordered table-striped table-hover tc-table table-primary footable">
						<thead>
							<tr>
								<th class="col-small center"><label><input type="checkbox" class="tc"><span class="labels"></span></label></th>
								<th><?php __('Name') ?></th>
								<th class="hidden-xs col-large center"><i class="fa fa-user" title="Author"></i></th>
								<th class="hidden-xs col-medium center"><i class="fa fa-comments" title="Post Comments"></i></th>
								<th class="hidden-xs col-medium center"><i class="fa fa-calendar" title="Date"></i></th>
								<th class="center col-small"><?php __('Actions') ?></th>
							</tr>
						</thead>
						<tbody>

							<?php 
								function generate_parent($all_posts, $parent = 0, $indent = ''){
									foreach ($all_posts as $post) {
										if ($post->parent != $parent) {
											continue;
										}
										?>
											<tr>
												<td><label><input type="checkbox" class="tc"><span class="labels"></span></label></td>
												<td><?php echo $indent.' '.$post->title ?></td>
												<td>Muhammad Hanif</td>
												<td class="col-medium center"><small class="badge center">100</small></td>
												<td>Test</td>
												<td>Test</td>
											</tr>
										<?php
										generate_parent($all_posts, $post->ID, $indent.'- ');
									}
								} // end of generate_parent()
								generate_parent($all_posts, 0, '');
							?>

							
							<tr>
								<td><label><input type="checkbox" class="tc"><span class="labels"></span></label></td>
								<td>My first sample post</td>
								<td>Muhammad Hanif</td>
								<td class="col-medium center"><small class="badge center">100</small></td>
								<td>Test</td>
								<td>Test</td>
							</tr>
						</tbody>
					</table>
				</div><!-- end of .well -->

				<?php endif; ?>
			</div>
		</div>
		<!-- END YOUR CONTENT HERE -->

<?php include 'include/footer.php'; ?>

<script src="assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/js/plugins/datatables/datatables.js"></script>
<script src="assets/js/plugins/datatables/datatables.responsive.js"></script>
<script src="assets/js/plugins/datatables/datatables.init.js"></script>