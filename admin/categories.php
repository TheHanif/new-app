<?php 
// Initialization
include_once 'include/init.php';

// Page title
$admin_title = 'Categories';

// Get type for custom post
$type = $_GET['type'];

// Header file
include 'include/header.php';
?>
<link href="assets/css/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
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
					<h1><?php echo __($admin_title); ?> <span class="sub-title"><?php __(ucfirst($type)); ?></span></h1>								
				</div>
				
				<?php get_messages(); ?>	

			</div><!-- /.col-lg-12 -->
		</div><!-- /.row -->
	<!-- END PAGE HEADING ROW -->

		<?php
		// Check page for loack status
		get_lock_status(); ?>
		
		<div class="row">
			<!-- START YOUR CONTENT HERE -->
			<div class="col-md-5">
				<div class="portlet">
					<div class="portlet-heading default-bg">
						<div class="portlet-title">
							<h4><?php __(((isset($_GET['action']) && $_GET['action'] == 'edit')? 'Edit' : 'Create new')); echo ' '; __('category'); ?></h4>
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="portlet-body">
						<form class="form-horizontal" action="<?php echo get_actual_url(false); ?>" role="form" method="post">
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php __('Name'); ?></label>
								<div class="col-sm-10">
									<input type="text" name="name" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php __('Slug'); ?></label>
								<div class="col-sm-10">
									<input type="text" disabled name="slug" class="form-control input-sm">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php __('Parent'); ?></label>
								<div class="col-sm-10">
									<select name="parent" class="form-control selectpicker">
										<option>Mustard</option>
										<option>Ketchup</option>
										<option>Relish</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php __('Image'); ?></label>
								<div class="col-sm-10">
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
							
							<div class="form-group">

								<div class="col-sm-12">
									<textarea name="description" rows='6' placeholder="<?php __('Category Description'); ?>" id="editor" class="form-control"></textarea>
								</div>
							</div>

							<div class="form-actions">
								<div class="form-group">
									<div class="col-sm-12">
										<button type="submit" class="btn btn-primary"><?php __('Submit'); ?></button>
										<button type="submit" class="btn btn-inverse"><?php __('Cancel') ?></button>
									</div>
								</div>
							</div>
						</form>
					</div>

				</div><!-- end of .portlet -->
			</div><!-- end of form -->
			<div class="col-md-7">
				<table class="table table-bordered table-hover tc-table">
					<thead>
						<tr>
							<th class="col-small center"><?php __('Image'); ?></th>
							<th><?php __('Name') ?></th>
							<th class="col-small"><?php __('Posts') ?></th>
							<th class="hidden-xs col-medium"><?php __('Date') ?></th>
							<th class="center col-small"><?php __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td></td>
							<td>Category Name</td>
							<td class="col-small center"><span class="badge">50</span></td>
							<td class="col-medium">Fate</td>
							<td class="col-small center">
								<div class="btn-group btn-group-xs">
									<a href="" class="btn btn-inverse"><i class="fa fa-pencil icon-only"></i></a>
									<a href="" class="btn btn-danger" onClick="return confirm('<?php __('Confirm delete?'); ?>');"><i class="fa fa-times icon-only"></i></a>
								</div>	
							</td>
						</tr>
						<tr>
							<td></td>
							<td><i class="fa fa-minus text-gray"></i> <i class="fa fa-minus text-gray"></i> Sub category</td>
							<td class="col-small center"><span class="badge">10</span></td>
							<td class="col-medium">Fate</td>
							<td class="col-small center">
								<div class="btn-group btn-group-xs">
									<a href="" class="btn btn-inverse"><i class="fa fa-pencil icon-only"></i></a>
									<a href="" class="btn btn-danger" onClick="return confirm('<?php __('Confirm delete?'); ?>');"><i class="fa fa-times icon-only"></i></a>
								</div>	
							</td>
						</tr>
					</tbody>
				</table>	
			</div>
			<!-- END YOUR CONTENT HERE -->
		</div>
<?php include 'include/footer.php'; ?>
<script src="assets/js/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script>
	$('.selectpicker').selectpicker('show');
</script>