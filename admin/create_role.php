<?php 
// Initialization
include_once 'include/init.php';

// Page title
$admin_title = 'Create Role';

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
				<form action="create_role.php" role="form" method="post">
					
					<div class="panel panel-default">
						<div class="panel-body">

							<div class="form-group">
								<label for="title"><?php __('Role and Capability Title'); ?></label>
								<input type="text" class="form-control input-lg" id="title" placeholder="<?php __('Title'); ?>">
							</div>
							
							<hr>
						<div class="form-horizontal">
						<?php foreach($capabilities_groups as $capabilities_group_name => $capabilities_group): ?>
							<div class="form-group">
								<label class="col-sm-3 control-label" style="margin-top:-5px"><?php __($capabilities_group_name); ?></label>
								<div class="col-sm-9">
								<?php foreach($capabilities_group as $capability_key => $capability_name): ?>
									<div class="tcb">
										<label>
											<input type="checkbox" value="<?php echo $capability_key; ?>" class="tc" name="capabilities_groups['<?php echo $capabilities_group_name; ?>'][<?php echo $capability_key; ?>]">
											<span class="labels"> <?php __($capability_name); ?></span>
										</label>
									</div>
								<?php endforeach; ?>
								</div>
							</div><!-- //.form-group -->
							<hr>
						<?php endforeach; ?>
						</div><!-- // .form-horizontal -->

						</div><!-- //.panel-body -->
					</div>

				</form>


			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>