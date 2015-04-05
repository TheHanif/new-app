<?php 
// Initialization
include_once 'include/init.php';

$Media = new media();

// Delete single media
if (isset($_GET['ID'])) {
	if ($Media->delete_media($_GET['ID']) > 0) {
		register_admin_message('Success', 'Media has been deleted successfully.', 'success');
	}else{
		register_admin_message('Not found', 'Media not found or already deleted. Please try again.', 'danger');
	}
}

// Delete multiple
if (isset($_POST['delete'])) {
	if (isset($_POST['media']) && count($_POST['media']) > 0) {
		$state = 1;
		foreach ($_POST['media'] as $ID) {
			if ($Media->delete_media($ID) <= 0) {
				$state = 0;
			}
		}
		if ($state == 1) {
			register_admin_message('Success', 'Media has been deleted successfully.', 'success');
		}else{
			register_admin_message('Not found', '1 or more media not found or already deleted. Please try again.', 'danger');
		}

	}else{
		register_admin_message('Warning', 'Please select media', 'warning');
	}
}

// Get all medias
$medias = $Media->get_media();

// Page title
$admin_title = 'Media';
?>
<link rel="stylesheet" href="assets/css/plugins/colorBox/colorbox.css">
<?php
// Header file
include 'include/header.php';
?>
<form action="media.php" method="post">
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
					<h1><?php echo __($admin_title); ?> <a href="media_upload.php" class="btn btn-default btn-sm pull-right"><i class="fa fa-plus"></i> <?php __('Upload media') ?></a> <?php if (isset($medias)): ?><button onClick="return confirm('<?php __('Do you really want to delete selected files?'); ?>');" type="submit" name="delete" class="btn btn-danger pull-right btn-sm"><i class="fa fa-trash-o"></i> <?php __('Delete selected') ?></button> <?php endif; ?> </h1>								
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

				<?php 
					if (!isset($medias)):
						echo "<p>";
						__($admin_title);
						echo " ";
						__(" not available.");
						echo "</p>";
					else:
				?>
			
			<!-- START YOUR CONTENT HERE -->
				
					<div class="well white padding-25">
						<!-- Gallery Style 2-->
						<ul class="tc-gallery-2 clearfix">
							<?php foreach ($medias as $key => $media) {

								$thumbnail = 'assets/images/paper-clip.png';

								//check if media is a image type
								if(strpos($media->type,"image") !== false){
									$file_directory = SITEURL."contents/uploads/".$Media->_date('Y/m/d/', $media->date);
									$thumbnail = $file_directory.str_replace('.', '-thumbnail.', $media->file);
									$large = $file_directory.str_replace('.', '-large.', $media->file);
								}
							?>
							<li class="thumbnail">
								<div class="thumb-preview">
									<div class="thumb-image">
										<img src="<?php echo $thumbnail; ?>" alt="" style="width:150px; height: 150px;">
									</div>
									<div class="gl-thumb-options">
										<?php if(strpos($media->type,"image") !== false): ?>
											<a class="gl-zoom" href="<?php echo $large; ?>" data-rel="colorbox" title="<?php echo $media->title; ?>">
												<i class="fa fa-search"></i>
											</a>
										<?php endif; ?>
										<div class="gl-toolbar">
											<div class="gl-option checkbox-inline">
												<input class="tc" type="checkbox" id="file_<?php echo $media->ID; ?>" value="<?php echo $media->ID; ?>" name="media[]">
												<label class="labels" for="file_<?php echo $media->ID; ?>"> <?php __('Select'); ?></label>
											</div>
											<div class="gl-group pull-right">
												<a href="media_edit.php?ID=<?php echo $media->ID; ?>"><?php __('Edit') ?></a>
												<button class="dropdown-toggle gl-toggle" type="button" data-toggle="dropdown">
													<i class="fa fa-caret-up"></i>
												</button>
												<ul class="dropdown-menu dropdown-caret dropdown-menu-right" role="">
													<li><a href="#"><i class="fa fa-download"></i> <?php __('Download'); ?></a></li>
													<li><a href="media.php?ID=<?php echo $media->ID; ?>" onClick="return confirm('<?php __('Do you really want to delete this file?'); ?>');"><i class="fa fa-trash-o"></i> <?php __('Delete'); ?></a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								<?php
									$name_part = explode('.', $media->file);
								?>
								<h5 class="gl-title"><?php echo $name_part[0]; ?><small>.<?php echo $name_part[1]; ?></small></h5>
								<div class="gl-description">
									<!-- <small class="pull-left">Design, Websites</small> -->
									<small class="pull-right"><?php echo $Media->_date('d/m/Y', $media->date); ?></small>
								</div>
							</li>
							<?php } ?>
						</ul>
					</div>
				
				<?php endif; ?>
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
	</form>
<?php include 'include/footer.php'; ?>
<script src="assets/js/plugins/colorBox/jquery.colorbox-min.js"></script>
<script type="text/javascript">	
		
		//colorbox function
		jQuery(function($) {
			var $overflow = '';
			var colorbox_params = {
			rel: 'colorbox',
			reposition:true,
			scalePhotos:true,
			scrolling:true,
			previous:'<i class="fa fa-arrow-left text-gray"></i>',
			next:'<i class="fa fa-arrow-right text-gray"></i>',
			close:'<i class="fa fa-times text-primary"></i>',
			current:'{current} of {total}',
			maxWidth:'100%',
			maxHeight:'100%',
			onOpen:function(){
				$overflow = document.body.style.overflow;
				document.body.style.overflow = 'hidden';
			},
			onClosed:function(){
				document.body.style.overflow = $overflow;
			},
			onComplete:function(){
				$.colorbox.resize();
			}
		};


			$('.thumbnail [data-rel="colorbox"]').colorbox(colorbox_params); // for enable gallery style 2
		
			$("#cboxLoadingGraphic").append("<i class='fa fa-spinner fa-spin'></i>");//let's add a custom loading icon for colorbox

		})
		
		//dropdown for gallery style 2
		$('.thumbnail .gl-toggle').parent()
			.on('show.bs.dropdown', function( ev ) {
				$(this).closest('.gl-thumb-options').css('overflow', 'visible');
			})
			.on('hidden.bs.dropdown', function( ev ) {
				$(this).closest('.gl-thumb-options').css('overflow', '');
			});

		$('.thumbnail').on('mouseenter', function() {
			var toggle = $(this).find('.gl-toggle');
				if ( toggle.parent().hasClass('open') ) {
					toggle.dropdown('toggle');
			}
		});
	</script>