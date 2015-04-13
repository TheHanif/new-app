<?php 
// Initialization
include_once 'include/init.php';

// Get type for custom post
$type = $_GET['type'];

$Posts = new post();

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
				if (!isset($all_posts)):
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
						tr*5>td*5>{Test}
					<tbody>
					</tbody>
				</table>

				<?php endif; ?>
			</div>
		</div>
		<!-- END YOUR CONTENT HERE -->
<?php include 'include/footer.php'; ?>