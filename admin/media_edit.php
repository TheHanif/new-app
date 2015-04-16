<?php 
// Initialization
include_once 'include/init.php';



$Media = new media();

if (isset($_POST['update'])) {
	if ($Media->save_media(NULL, $_POST, $_GET['ID']) > 0) {
		register_admin_message('Success', 'Media has been updated successfully.', 'success');
	}
}

/**
 * Scale or Resize
 */
if(!empty($_POST['scale'])){
	$Media->scale($_GET['ID'], $_POST);
	register_admin_message('Crop image', 'Your image has been resized successfully.', 'success');
}

/**
 * Flip / Rotate
 */
if(!empty($_POST['flip']) || !empty($_POST['rotate'])){
	$Media->flip_rotate($_GET['ID'], $_POST);
	register_admin_message('Edit image', 'Your image has been edited successfully.', 'success');
}

/**
 * Crop
 */
if(!empty($_POST['crop'])){
	$Media->crop($_GET['ID'], $_POST);
	register_admin_message('Crop image', 'Your image has been croped successfully.', 'success');
}

/**
 * Restore
 */
if(isset($_GET['restore']) && $Media->restore_original($_GET['ID'])){
	register_admin_message('Media restore', 'Your image has been restored successfully.', 'success');
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
							<a href="media_edit.php?ID=<?php echo $_GET['ID']; ?>&restore=true" class="btn btn-default btn-sm pull-right" id="upload" onClick="return confirm('<?php __('All changes will be dicard, confirm restore?') ?>');"><i class="fa fa-refresh"></i> <?php __('Restore original image'); ?></a>
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

							<?php if(strpos($media->type, 'image') !== false): ?>
								<div class="media-image clearfix">
									<img src="<?php echo $file_url.'?'.time(); ?>" align="Preview" class="thumbnail" style='padding: 0;' id="cropbox" />
								</div>
								<br>
								<div class="btn-group flip-rotate" data-toggle="buttons">
									<label class="btn btn-default btn-lg" title="Flip Verticle">
										<input type="radio" name="flip" id="flip1" value='v'>
										<i class="fa fa-arrows-v"></i>
									</label>
									<label class="btn btn-default btn-lg" title="Flip Horizontal">
										<input type="radio" name="flip" id="flip2" value='h'>
										<i class="fa fa-arrows-h"></i>
									</label>
									<label class="btn btn-default btn-lg" title="Rotate anti clockwise">
										<input type="radio" name="rotate" id="rotate1" value='ac'>
										<i class="fa fa-rotate-left"></i>
									</label>
									<label class="btn btn-default btn-lg" title="Rotate clockwise">
										<input type="radio" name="rotate" id="rotate2" value='c'>
										<i class="fa fa-rotate-right"></i>
									</label>
								</div>
								<hr>
							<?php endif; ?>

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
												<?php __('Attributes') ?> <span class="pull-right"><i class="fa fa-angle-down bigger-110"></i></span>
											</h5>
										</a>
									</div>
									<div id="collapseOne" class="panel-collapse collapse in">
										<div class="panel-body">
											<i class="fa fa-calendar"></i> <?php __('Uploaded on:') ?> <?php echo $Media->_date('M d, Y @ H:i', $media->date); ?>
											<hr>
											<label for="url" style='font-weight:normal'><?php __('File URL:') ?></label>
											<input type="text" id='url' disabled class="form-control input-sm" value='<?php echo $file_url; ?>'>
											<hr>
											<?php __('File name:') ?> <strong><?php echo $media->file; ?></strong>
											<hr>
											<?php __('Type:') ?> <strong><?php echo $media->type; ?></strong>
											<hr>
											<?php __('File size:') ?> <strong>
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
												__('Dimensions:'); echo ' <strong>'. $dimensions[0] . ' × ' . $dimensions[1].' '; __('Pixels'); echo '</strong>';
											}
											?>
											</strong>
											<hr>
											<button class="btn btn-sm btn-success pull-right" type='submit' name='update' value='submit'><?php __('Update') ?></button>
										</div>
									</div>
								</div><!-- // attributes -->
								
								<?php if(strpos($media->type, 'image') !== false): ?>
								<div class="panel panel-default">
									<div class="panel-heading ">
										<a data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo">
											<h5 class="panel-title">
												<?php __('Resize Image') ?> <span class="pull-right"><i class="fa fa-angle-right bigger-110"></i></span>
											</h5>
										</a>
									</div>
									<div id="collapseTwo" class="panel-collapse collapse">
										<div class="panel-body">
											<?php __('For best results the scaling should be done before performing any other operations on it like crop, rotate, etc.') ?>
											<br><br>
											<em><?php __('Original dimensions'); ?> <?php echo $dimensions[0] . '×' . $dimensions[1]; ?> PX</em>
											<hr>
											<label class="control-label" style="padding-top:2px; font-weight:normal;">
												<div class="tcb">
													<label>
														<input type="checkbox" value="1" class="tc" name="scale_all">
														<span class="labels"> <?php __('Update all sizes'); ?></span>
													</label>
												</div>
												
											</label>
											<hr>
											<div class="row">
												<div class="col-sm-3"><input type="text" name='width' class="form-control input-sm" value='<?php echo $dimensions[0]; ?>'></div>
												<div class="col-sm-1" style='padding:0; padding-top:5px; margin:0; text-align:center'>×</div>
												<div class="col-sm-3" style='padding-left:0;'><input type="text" name='height' class="form-control input-sm" value='<?php echo $dimensions[1]; ?>'></div>
												
												<div class="col-sm-4">
												<button class="btn btn-sm btn-success pull-right" type='submit' name='scale' value='scale'><?php __('Resize') ?></button>
												</div>
											</div>
										</div>
									</div>
								</div><!-- // Resize Image -->
								<div class="panel panel-default">
									<div class="panel-heading ">
										<a data-toggle="collapse" data-parent="#accordion1" href="#collapseThree">
											<h5 class="panel-title">
												<?php __('Croping options') ?> <span class="pull-right"><i class="fa fa-angle-right bigger-110"></i></span>
											</h5>
										</a>
									</div>
									<div id="collapseThree" class="panel-collapse collapse">
										<div class="panel-body">
											<?php __('The thumbnail image can be cropped differently. For example it can be square or contain only a portion of the original image to showcase it better. Here you can select whether to apply changes to all image sizes or make the thumbnail different.') ?>
											<br><br><img src="<?php echo str_replace('.', '-thumbnail.', $file_url).'?'.time();  ?>" alt=""><br>
											<?php __('Current thumbnail') ?>
											<br><br>
											<strong><?php __('Apply changes to:') ?></strong>

												<div class="tcb">
													<label>
														<input type="radio" name="radio_crop" id="radio_crop1" value="thumbnail" checked class="tc">
														<span class="labels"> <?php __('Thumbnail') ?></span>
													</label>
												</div>
												
												<div class="tcb">
													<label>
														<input type="radio" name="radio_crop" id="radio_crop2" value="except" class="tc">
														<span class="labels"> <?php __('All sizes except thumbnail') ?></span>
													</label>
												</div>
												

											 
											
											<hr>


											<strong><?php __('Selection options:') ?></strong><br>
											<div class="btn-group" data-toggle="buttons">
												<label class="btn btn-default active">
													<input type="radio" name="options" id="custom" checked='checked'>
													<?php __('Custom') ?>
												</label>
												<label class="btn btn-default">
													<input type="radio" name="options" id="ratio">
													4:3
												</label>
												<label class="btn btn-default">
													<input type="radio" name="options" id="square">
													1:1
												</label>
											</div>



											<input type="hidden" id="x" name="x" />
											<input type="hidden" id="y" name="y" />
											<input type="hidden" id="w" name="w" />
											<input type="hidden" id="h" name="h" />
											<input type="hidden" id="iw" name="iw" />
											<input type="hidden" id="ih" name="ih" />
											<hr>
											<button class="btn btn-sm btn-success pull-right" type='submit' name='crop' value='crop'  onClick="return checkCoords();">Crop</button>
										</div>
									</div>
								</div><!-- // Crop -->
								<?php endif; ?>
							</div><!-- Accordion style 1-->		
						</div><!-- sidebar -->
					</div>
				</form>
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>
<style>
.media-image img {
	max-height: 480px;
	max-width: 100%;
}
</style>

<link rel="stylesheet" href="assets/css/jquery.Jcrop.min.css" type="text/css" />
<script type="text/javascript" src="assets/js/jquery.Jcrop.min.js"></script>


<script type="text/javascript">
	

	$('.flip-rotate').find('input').on('change', function(e) {
		e.preventDefault();
		$('form').submit();
	});

	$('form').on('keydown', function(e) {
		if(e.keyCode == 13) {
				e.preventDefault(); // Prevent form submission
			}
		});

	// Croping start
	var jcrop_api;

	$(function(){

		$('#cropbox').Jcrop({
			onSelect: updateCoords
		},function(){
        jcrop_api = this;
      });

	});

	function updateCoords(c)
	{
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);
		$('#iw').val($('#cropbox').width());
		$('#ih').val($('#cropbox').height());
	};

	function checkCoords()
	{
		if (parseInt($('#w').val())) return true;
		alert('Please select a crop region then press crop.');
		return false;
	};

	$('#square').change(function(e) {
      jcrop_api.setOptions(this.checked?
        { aspectRatio: 1 }: { aspectRatio: 0 });
      jcrop_api.focus();
    });
    $('#ratio').change(function(e) {
      jcrop_api.setOptions(this.checked?
        { aspectRatio: 4/3 }: { aspectRatio: 0 });
      jcrop_api.focus();
    });
    $('#custom').change(function(e) {
      jcrop_api.setOptions(this.checked?
        { aspectRatio: 0 }: { aspectRatio: 0 });
      jcrop_api.focus();
    });
    // end of croping

</script>