<?php 
// Initialization
include_once 'include/init.php';

$is_allowed = is_allowed(NULL, array('Site'=>array('manage-themes')));


// Page title
$admin_title = 'Menus';

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
				
				<br>
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
				<div class="tc-tabs"><!-- Nav tabs style 2-->
					<ul class="nav nav-tabs tab-color-dark background-dark">
						<li class="active"><a href="#manage_menu" data-toggle="tab"><?php __('Manage menu') ?></a></li>
						<li><a href="#manage_location" data-toggle="tab"><?php __('Manage Location') ?></a></li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="manage_menu">
							<div class="panel panel-default">
								<div class="panel-body">
								
									<form action="" method="POST" class="form-inline" role="form">
										<?php __('Select a menu'); ?>
										<div class="form-group">
											<select name="language" class="selectpicker form-control" id="language">
												<option value="">None</option>
											</select>
										</div>
									
										<button type="submit" class="btn btn-primary">Edit</button>

										<?php __('or') ?> <a href="menus.php"><?php __('Create a new menu'); ?></a>
									</form>
								 </div>
							</div><!-- // .panel -->

							<div class="row">
								<div class="col-xs-12 col-sm-3 col-md-3 tc-accordion" id="accordion">
									
									<div class="portlet">
										<div class="portlet-heading ">
											<div class="portlet-title">
												<h4>Portlet</h4>
											</div>
											<div class="portlet-widgets">
												<span class="divider"></span>
												<a data-toggle="collapse" data-parent="#accordion" href="#notes-warn"><i class="fa fa-chevron-down"></i></a>
											</div>
											<div class="clearfix"></div>
										</div>
										<div id="notes-warn" class="panel-collapse collapse">
											<div class="portlet-body">
												                                  													
											</div><!-- // .portlet-body -->
										</div>
									</div><!-- // .portlet -->

									
								</div><!-- // left -->

								<div class="col-xs-12 col-sm-9 col-md-9">structure</div><!-- // structure -->
							</div><!-- // .row -->
							
						</div><!-- // #manage_menu -->

						<div class="tab-pane" id="manage_location">
							Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee.
						</div><!-- // #manage_location -->
						
					</div>
				</div><!--nav-tabs style 2-->
			<!-- END YOUR CONTENT HERE -->
	
			</div>
		</div>
<?php include 'include/footer.php'; ?>