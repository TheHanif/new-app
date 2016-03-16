<?php 
// Initialization
include_once 'include/init.php';

$plugins = new plugins();

$is_allowed = is_allowed(NULL, array('Plugins'=>array('manage-plugins')));


// Page title
$admin_title = 'Plugins';

// List all installed plugin from plugin dir
$plugin_list = $plugins->get_plugin_list();

if (isset($_GET['plugin']) && isset($_GET['status'])) {
	$plugins->set_plugin($_GET['plugin'], $_GET['status']);

	$message = ($_GET['status'] == 'on')? 'Activated' : 'Dectivated';

	register_admin_message('Success', $message.' successfully.', 'success');
}

// active plugins
$active_plugins = $plugins->get_active_plugins();


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

				if (!isset($plugin_list) || (isset($plugin_list) && count($plugin_list) <= 0)):
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
							<th><?php __('Name'); ?></th>
							<th><?php __('Version'); ?></th>
							<th><?php __('Author'); ?></th>
							<th><?php __('Description'); ?></th>
							<th class="col-medium center"><?php __('Action'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($plugin_list as $key => $plugin):

							$is_active = in_array($key, $active_plugins)? true : false;


							$status = $is_active? 'off' : 'on';
							$title = $is_active? 'Disable' : 'Enable';
							$class = $is_active? 'fa-eye-slash' : 'fa-eye';
						?>
						<tr class="<?php echo $is_active? 'success' : '' ?>" >
							<td><?php echo $plugin['name']; ?></td>
							<td><?php echo $plugin['version']; ?></td>
							<td><?php echo $plugin['author']; ?></td>
							<td><?php echo $plugin['description']; ?></td>

							
							<td class="col-medium center">
								<div class="btn-group btn-group-sm">
									<a href="plugins.php?plugin=<?php echo $key ?>&status=<?php echo $status; ?>" class="btn btn-<?php echo $is_active? 'danger' : 'success' ?>" title="<?php __($title); ?>"><i class="fa <?php echo $class; ?> icon-only"></i></a>
								</div>	
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>

				<?php endif; ?>
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>