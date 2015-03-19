<?php 
// Initialization
include_once 'include/init.php';

// Get status for form submission
$is_allowed = is_allowed(HAS_USERS_ROLE, array('Users'=>array('manage-roles')));


// Delete role
if (isset($_GET['ID']) && $is_allowed) {
	if ($Users->delete_role($_GET['ID']) > 0) {
		register_admin_message('Success', 'Role has been deleted successfully.', 'success');
	}else{
		register_admin_message('Not found', 'Role not found or already deleted. Please try again.', 'danger');
	}
}

// Select all roles
$roles = $Users->get_roles();

// Page title
$admin_title = 'Roles and Capabilities';

$available_groups = $Users->get_capabilities_groups();

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
					<h1 class='clearfix'><?php __($admin_title); ?> <?php if(is_allowed(HAS_USERS_ROLE, array('Users'=>array('manage-roles')))): ?> <a href="create_role.php" class="btn btn-default btn-sm pull-right"><i class="fa fa-plus"></i> <?php __('New Role') ?></a><?php endif; ?></h1>
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
				if (!isset($roles)):
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
							<th>Role TItle</th>
							<th class="hidden-xs">Role Description</th>
							<th class="hidden-xs">Area available</th>
							<th class="hidden-xs">Date</th>
							<th class="col-medium center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($roles as $role):
							$role_object = json_decode($role->role_object);
						?>
						<tr>
							<td><?php echo $role->role_title; ?></td>
							<td><?php echo $role->role_description; ?></td>
							<td>
								<ul class="list-unstyled">
									<?php foreach($role_object as $object_key => $object ): ?>
									<li><?php echo $object_key; ?> (<?php echo count((array)$object); ?> / <?php echo count($available_groups[$object_key]) ?>)</li>
								<?php endforeach; ?>
								</ul>
							</td>
							<td class="col-medium"><?php echo $Users->_date('d-m-Y', $role->role_ts); ?></td>
							<td class="col-medium center">
								<div class="btn-group btn-group-sm">
									<a href="create_role.php?ID=<?php echo $role->role_id; ?>" class="btn btn-inverse"><i class="fa fa-pencil icon-only"></i></a>
									<a href="user_roles.php?ID=<?php echo $role->role_id; ?>" class="btn btn-danger" onClick="return confirm('<?php __('Confirm delete?'); ?>');"><i class="fa fa-times icon-only"></i></a>
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