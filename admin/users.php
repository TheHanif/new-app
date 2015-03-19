<?php 
// Initialization
include_once 'include/init.php';

// Get status for form submission
$is_allowed = is_allowed(HAS_USERS, array('Users'=>array('manage-users', 'delete-users')));

// Delete role
if (isset($_GET['ID']) && $is_allowed) {
	if ($Users->delete_user($_GET['ID']) > 0) {
		register_admin_message('Success', 'User has been deleted successfully.', 'success');
	}else{
		register_admin_message('Not found', 'User not found or already deleted. Please try again.', 'danger');
	}
}

// Select all roles
$all_users = $Users->get_users();

// Page title
$admin_title = 'Users';

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
				if (!isset($all_users) || (isset($all_users) && count($all_users) <= 1)):
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
							<th>Name</th>
							<th>Username</th>
							<th>Email</th>
							<th class="hidden-xs">Date</th>
							<th class="col-medium center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($all_users as $user):
							if($user->user_id == $Users->get_logged_id()) continue;
							$user_profile = $Users->get_profile($user->user_id);
						?>
						<tr>
							<td><?php echo $user_profile->user_name; ?></td>
							<td><?php echo $user->user_username; ?></td>
							<td><?php echo $user_profile->user_email; ?></td>
							
							<td class="col-medium"><?php echo $Users->_date('d-m-Y', $user->user_ts); ?></td>
							<td class="col-medium center">
								<div class="btn-group btn-group-sm">
									<a href="create_user.php?ID=<?php echo $user->user_id; ?>" class="btn btn-inverse"><i class="fa fa-pencil icon-only"></i></a>
									<a href="users.php?ID=<?php echo $user->user_id; ?>" class="btn btn-danger" onClick="return confirm('<?php __('Confirm delete?'); ?>');"><i class="fa fa-times icon-only"></i></a>
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