<?php 
// Initialization
include_once 'include/init.php';

$ID = (isset($_GET['update']))? $Users->get_logged_id() : NULL;
$ID = (isset($_GET['ID']))? $_GET['ID'] : $ID;

// Get status for form submission
$is_allowed = is_allowed(HAS_USERS, array('Users'=>array('manage-users', 'create-users')));

// Proccess submitted form data
if (isset($_POST['submit']) && $is_allowed) {
	$result = $Users->save_user($_POST, $ID);
	if ($result > 0) {
		register_admin_message('Success', 'User updated/created successfully.', 'success');
	}
}

if (isset($ID)) {
	$Users->where('user_id', $ID);
	$Users->select(array('user_username'=>'user_username'));
	$Users->from($Users->table_name);

	$user = $Users->result();
	
	$profile = $Users->get_profile($ID);
}

// Page title
$admin_title = (isset($ID))? 'Edit profile' : 'Create User';

// Header file
include 'include/header.php';
?>
<!-- PAGE LEVEL PLUGINS STYLES -->
<link href="assets/css/plugins/select2/select2.css" rel="stylesheet">
<link href="assets/css/plugins/select2/select2.custom.min.css" rel="stylesheet">
<link href="assets/css/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/plugins/bootstrap-wysihtml/bootstrap-wysihtml5.css">
<link rel="stylesheet" href="assets/css/plugins/bootstrap-editable/bootstrap-editable.css">
<link rel="stylesheet" href="assets/css/plugins/bootstrap-datepicker/datepicker.css">

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
								<label class="col-sm-3 control-label"><?php __('Name') ?>:</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" value="<?php echo (isset($ID))? $profile->user_name : '' ?>" name="name">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label"><?php __('Display name') ?>:</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" value="<?php echo (isset($ID))? $profile->user_display_name : '' ?>" name="display_name">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label"><?php __('Email') ?>:</label>
								<div class="col-sm-3">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
										<input type="email" class="form-control" value="<?php echo (isset($ID))? $profile->user_email : '' ?>" name="email">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label"><?php __('Username') ?>:</label>
								<div class="col-sm-3">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-user"></i></span>
										<input type="text" <?php echo (isset($ID))? 'disabled' : ''; ?> value="<?php echo (isset($ID))? $user->user_username : '' ?>" class="form-control" name="username">
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label"><?php __('Profile photo') ?>:</label>
								<div class="col-sm-3">
									<div class="input-group">
										<span class="input-group-btn">
											<span class="btn btn-file">
												<?php __('Browse'); ?> <input type="file">
											</span>
										</span>
										<input type="text" class="form-control" readonly>
									</div>
								</div>
							</div>

							<hr class="separator">
							<?php if(isset($ID)): ?>
							<div class="form-group">
								<label class="col-sm-3 control-label"></label>
								<div class="col-sm-9">
									<div class="tcb">
										<label>
											<input type="checkbox" name="password" value="yes" class="tc tc-red">
											<span class="labels"> <?php __('Tick to Pickup Pasword'); ?></span>
										</label>
									</div>
								</div>
							</div>
							<?php else: ?>
								<input type="hidden" name="password" value="yes" class="tc tc-red">
							<?php endif; ?>
								<div class="myPassword" style="<?php echo (isset($ID))? 'display: none;' : ''; ?>">
									<?php if(isset($_GET['update'])): ?>
									<div class="form-group">
										<label class="col-sm-3 control-label"><?php __('Existing Password') ?>:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input type="password" name="old_password" class="form-control" id="form-field-1">
											</div>
										</div>
									</div>
									<?php endif; ?>
									<div class="form-group">
										<label class="col-sm-3 control-label"><?php __('New Password') ?>:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input type="password" name="password1" class="form-control" id="form-field-2">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label"><?php __('Confirm New Password'); ?>:</label>
										<div class="col-sm-3">
											<div class="input-group">
												<input type="password" name="password2" class="form-control" id="form-field-3">
											</div>
										</div>
									</div>
								</div>
							
							<hr class="separator">
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php __('User role'); ?>:</label>
								<div class="col-sm-3">
									<select name="role" class="form-control selectpicker">
									<?php 
										$roles = $Users->get_roles();
										foreach ($roles as $role) {
											?><option value="<?php echo $role->role_id; ?>" ><?php __($role->role_title); ?></option><?php
										}
									?>
									</select>
								</div>
							</div>
							
							<div class="form-actions">
								<div class="form-group">
									<div class="col-sm-offset-3 col-sm-9">
										<button type="submit" name="submit" class="btn btn-primary"><?php __('Submit'); ?></button>
										<button type="reset" class="btn btn-inverse"><?php __('Reset'); ?></button>
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
<!-- PAGE LEVEL PLUGINS JS -->
<script src="assets/js/plugins/bootstrap-wysihtml/wysihtml.min.js"></script>
<script src="assets/js/plugins/bootstrap-wysihtml/bootstrap-wysihtml.js"></script>
<script src="assets/js/plugins/bootstrap-editable/bootstrap-editable.min.js"></script>
<script src="assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<script src="assets/js/plugins/select2/select2.min.js"></script>
<script src="assets/js/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<!-- REQUIRE FOR SPEECH COMMANDS -->
<script src="assets/js/speech-commands.js"></script>
<script src="assets/js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- initial page level scripts for examples -->
<script src="assets/js/plugins/slimscroll/jquery.slimscroll.init.js"></script>
<script type="text/javaScript">
	$(document).ready(function() {
		// password checkbox function
		$(":checkbox").click(function(event) {
		if ($(this).is(":checked"))
			$(".myPassword").show();
		else
			$(".myPassword").hide();
		});

		$('.selectpicker').selectpicker('show');
		
		// wysihtml editor
		$('#about-editor').wysihtml5();
		
		//toggle `popup` / `inline` mode
		$.fn.editable.defaults.mode = 'inline';     

		//make email editable
		$(function(){
			$('#email').editable({
		//uncomment bellow lines to send data on server
				//pk: 1,
				//url: '/post',
				title: 'Update your email',
				mode: 'inline', //can also use popup
			});
		});
		//make date editable with bootstrap datepicker plugin
		$(function(){
			$('#dob').editable({
				type: 'date',
				format: 'yyyy-mm-dd',    
				viewformat: 'dd/mm/yyyy',
				title: 'Date of Birth',
				placement:'right',
				datepicker: {
						weekStart: 1
					}
			});
		});				
		//custome button style for editable			
		$.fn.editableform.buttons = 
			'<button type="submit" class="btn btn-primary editable-submit btn-sm"><i class="fa fa-check icon-only"></i></button>' +
			'<button type="button" class="btn editable-cancel btn-inverse btn-sm"><i class="fa fa-times icon-only"></i></button>';         			
		
		// for more document http://vitalets.github.io/x-editable/docs.html
		
		$('.datepicker').datepicker();			
	});

	// Custome File Input
	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, 'http://qsthemes.com/').replace(/.*\//, '');
		input.trigger('fileselect', [numFiles, label]);
	});

	$(document).ready( function() {
		$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
    
			var input = $(this).parents('.input-group').find(':text'),
			log = numFiles > 1 ? numFiles + ' files selected' : label;
    
			if( input.length ) {
				input.val(log);
			} else {
				if( log ) alert(log);
			}
    
		});
	});
</script>