<?php 
// Initialization
include_once 'include/init.php';

$ID = (isset($_GET['ID']))? $_GET['ID'] : NULL;

// Get status for form submission
$is_allowed = is_allowed(HAS_USERS_ROLE, array('Users'=>array('manage-roles')));

// Proccess submited data
if (isset($_POST['submit']) && $is_allowed) {	
	$result = $Users->save_role($_POST['title'], $_POST['description'], $_POST['capabilities_groups'], $ID);
	if($result > 0){
		register_admin_message('Success', 'Your Role updated/created successfully.', 'success');
	}
}

// Select role from database to edit
if (!is_null($ID) && $is_allowed) {
	$role = $Users->get_roles($ID);
	if ($Users->row_count() > 0) {
		$role_object = json_decode($role->role_object);
	}else{
		register_admin_message('Not found', 'Role not found. Please try again.', 'danger');
	}
}

// Page title
$admin_title = (isset($ID))? 'Edit Role' : 'Create Role';

// Get User object from builtin/capabilities.php
$capabilities_groups = $Users->get_capabilities_groups();

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
					<h1><?php echo __($admin_title); ?> <a href="user_roles.php" class="btn btn-default btn-sm pull-right"><i class="fa fa-arrow-left"></i> <?php __('Cancel') ?></a></h1>
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
				<form action="<?php echo get_actual_url(false); ?>" role="form" method="post">
					
					<div class="panel panel-default">
						<div class="panel-body">

							<div class="form-group">
								<label for="title"><?php __('Role and Capability Title'); ?></label>
								<input type="text" name="title" class="form-control input-lg" id="title" value="<?php echo (isset($role))? $role->role_title : ''; ?>" placeholder="<?php __('Title'); ?>">
							</div>

							<div class="form-group">
								<label for="description"><?php __('Role Description'); ?></label>
								<textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="<?php __('Decription'); ?>"><?php echo (isset($role))? $role->role_description : ''; ?></textarea>
							</div>
							
							<hr>
							<div class="form-horizontal">
							<?php foreach($capabilities_groups as $capabilities_group_name => $capabilities_group): ?>
								<div class="form-group">
									<label class="col-sm-3 control-label" style="margin-top:-5px"><?php __(ucfirst($capabilities_group_name)); ?></label>
									<div class="col-sm-9">
									<?php foreach($capabilities_group as $capability_key => $capability_name): ?>
										<div class="tcb">
											<label>
												<input type="checkbox" <?php echo (isset($role) && isset($role_object->$capabilities_group_name->$capability_key))? 'checked' : ''; ?> value="1" class="tc" name="capabilities_groups[<?php echo $capabilities_group_name; ?>][<?php echo $capability_key; ?>]">
												<span class="labels"> <?php __($capability_name); ?> (<?php echo str_replace(' ', '-', strtolower($capability_name)); ?>)</span>
											</label>
										</div>
									<?php endforeach; ?>
									</div>
								</div><!-- //.form-group -->
								<hr>
							<?php endforeach; ?>
							</div><!-- // .form-horizontal -->

							
								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-9">
										<button class="btn btn-primary" type="submit" name="submit" value="submit">Submit</button>
									</div>
								</div>
							

						</div><!-- //.panel-body -->
					</div>

				</form>

			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>