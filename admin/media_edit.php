<?php 
// Initialization
include_once 'include/init.php';



$Media = new media();

if (isset($_POST['update'])) {
	if ($Media->save_media(NULL, $_POST, $_GET['ID']) > 0) {
		register_admin_message('Success', 'Media has been updated successfully.', 'success');
	}
}

$media = $Media->get_media($_GET['ID']);
$media = $media[0];

$file_url = SITEURL."contents/uploads/".$Media->_date('Y/m/d/', $media->date).$media->file;
$file_path = ABSPATH."contents/uploads/".$Media->_date('Y/m/d/', $media->date).$media->file;


// Page title
$admin_title = 'Edit media';

// Header file
include 'include/header.php';
?>
<link rel="stylesheet" href="assets/css/plugins/bootstrap-wysihtml/bootstrap-wysihtml5.css">
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
					<h1><?php echo __($admin_title); ?>
						<?php if(strpos($media->type, 'image') !== false && file_exists(str_replace('.', '-backup.', $file_path))): ?>
							<a href="media_edit.php?id=<?php echo $_GET['ID']; ?>&restore=true" class="btn btn-default btn-sm pull-right" id="upload"><i class="fa fa-refresh"></i> <?php __('Restore original image'); ?></a>
						<?php endif; ?>
					</h1>								
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
				<form action="media_edit.php?ID=<?php echo $_GET['ID']; ?>" method='post' role="form">
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<label class="control-label"><?php __('Title'); ?></label>
								<input type="text" class="form-control" value="<?php echo $media->title; ?>" name="title">
							</div><!-- // title -->

							<div class="form-group">
								<label class="control-label"><?php __('Caption'); ?></label>
								<textarea name="caption"class="form-control"><?php echo $media->caption; ?></textarea>
							</div><!-- // title -->

							<div class="form-group">
								<label class="control-label"><?php __('Description'); ?></label>
								<textarea name="description" rows='10' id="editor" class="form-control"><?php echo $media->description; ?></textarea>
							</div><!-- // title -->

						</div><!-- meta -->
						<div class="col-sm-4">
							<div class="panel-group tc-accordion" id="accordion1"><!-- Accordion style 1-->
								<div class="panel panel-default">
									<div class="panel-heading accordion-active">
										<a data-toggle="collapse" data-parent="#accordion1" href="#collapseOne">
											<h5 class="panel-title">
												Attributes <span class="pull-right"><i class="fa fa-angle-down bigger-110"></i></span>
											</h5>
										</a>
									</div>
									<div id="collapseOne" class="panel-collapse collapse in">
										<div class="panel-body">
											<i class="fa fa-calendar"></i> Uploaded on: <?php echo $Media->_date('M d, Y @ H:i', $media->date); ?>
											<hr>
											<label for="url" style='font-weight:normal'>File URL:</label>
											<input type="text" id='url' disabled class="form-control input-sm" value='<?php echo $file_url; ?>'>
											<hr>
											File name: <strong><?php echo $media->file; ?></strong>
											<hr>
											Type: <strong><?php echo $media->type; ?></strong>
											<hr>
											File size: <strong>
											<?php 
												$bytes=filesize($file_path);
												$sz = array('Bytes','KB','MB','GB','TB','P');
												$factor = floor((strlen($bytes) - 1) / 3);
												echo sprintf("%.2f", $bytes / pow(1024, $factor)) . ' ' . @$sz[$factor];
											?></strong>
											<hr>
											<?php
											if(strpos($media->type, 'image') !== false){
												$dimensions = GetimageSize($file_path);
												echo 'Dimensions: <strong>'. $dimensions[0] . ' × ' . $dimensions[1] .' Pixels</strong>';
											}
											?>
											</strong>
											<hr>
											<button class="btn btn-sm btn-success pull-right" type='submit' name='update' value='submit'><?php __('Update') ?></button>
										</div>
									</div><!-- // attributes -->
								</div>
								<div class="panel panel-default">
									<div class="panel-heading ">
										<a data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo">
											<h5 class="panel-title">
												Collapsible Group Item #2 <span class="pull-right"><i class="fa fa-angle-right bigger-110"></i></span>
											</h5>
										</a>
									</div>
									<div id="collapseTwo" class="panel-collapse collapse">
										<div class="panel-body">
											Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
										</div>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree">
											<h5 class="panel-title">
												Collapsible Group Item #3 <span class="pull-right"><i class="fa fa-angle-right bigger-110"></i></span>
											</h5>
										</a>
									</div>
									<div id="collapseThree" class="panel-collapse collapse">
										<div class="panel-body">
											Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
										</div>
									</div>
								</div>
							</div><!-- Accordion style 1-->		
						</div><!-- sidebar -->
					</div>
				</form>
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>
<script src="assets/js/plugins/bootstrap-wysihtml/wysihtml.min.js"></script>
<script src="assets/js/plugins/bootstrap-wysihtml/bootstrap-wysihtml.js"></script>
<script src="assets/js/plugins/bootstrap-editable/bootstrap-editable.min.js"></script>
<script type="text/javaScript">
	$(document).ready(function() {
		// wysihtml editor
		$('#editor').wysihtml5();		
	});
</script>	