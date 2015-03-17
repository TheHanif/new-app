<?php 
// Initialization
include_once 'include/init.php';

// Page title
$admin_title = 'Create User';

// Variable to active select page
// $page = get_script_name();

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
					<h1><?php __($admin_title); ?> <span class="sub-title">sub title</span></h1>								
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
				<div class="panel panel-default">
					<div class="panel-body">
						<form action="<?php echo get_actual_url(false); ?>" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label class="col-sm-3 control-label">First Name:</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" placeholder="john">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Last Name:</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" placeholder="Smith">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Company:</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" placeholder="eKoders, Ltd.">
								</div>
							</div>													
							<div class="form-group">
								<label class="col-sm-3 control-label">Email</label>
								<div class="col-sm-3">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
										<input type="email" class="form-control" placeholder="john.smith@example.com" disabled>
									</div>
								</div>
							</div>
							
							<hr class="separator">
							
							<div class="form-group">
								<label class="col-sm-3 control-label"></label>
								<div class="col-sm-9">
									<div class="tcb">
										<label>
											<input type="checkbox" class="tc tc-red">
											<span class="labels"> Tick to Pasword Modifaction</span>
										</label>
									</div>
								</div>
							</div>
								<div class="myPassword" style="display: none;">
									<div class="form-group">
										<label class="col-sm-3 control-label">Existing Password:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input type="password" class="form-control" id="form-field-1">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">New Password:</label>
										<div class="col-sm-34">
											<div class="input-group">
												<input type="password" class="form-control" id="form-field-2">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label">Confirm New Password:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input type="password" class="form-control" id="form-field-3">
											</div>
										</div>
									</div>
								</div>
							
							<hr class="separator">
							
							<div class="form-group">
								<label class="col-sm-3 control-label">About Me:</label>
								<div class="col-sm-9">
									<textarea id="about-editor" class="form-control"></textarea>
								</div>
							</div>													
							<div class="form-group">
								<label class="col-sm-3 control-label">Address:</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" placeholder="795 Folsom Ave, Suite 600">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">City:</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" placeholder="San Francisco">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">State/Region:</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" placeholder="Florida">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Zip code:</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" placeholder="94107">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Country:</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" placeholder="United State">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Phone Number:</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" placeholder="+1 5643234765">
								</div>
							</div>												
							<div class="form-actions">
								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-9">
										<button type="submit" class="btn btn-primary">Submit</button>
										<button type="submit" class="btn btn-inverse">Cancel</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>