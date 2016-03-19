<?php 
// Initialization
include_once 'include/init.php';

$is_allowed = is_allowed(NULL, array('Site'=>array('manage-themes')));

print_f($_POST);

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
									
										<button type="submit" class="btn btn-primary"><?php __('Edit'); ?></button>

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

								<div class="col-xs-12 col-sm-9 col-md-9">


								
								
									<form action="" method="POST" class="" role="form">
									
										<div class="panel panel-default">
											<div class="panel-heading form-inline clearfix">
												<div class="form-group">
													<label class="label-control" for="menu_name"><?php __('Menu name'); ?></label>
													<input type="text" required class="form-control input-sm" id="menu_name">
												</div>

												<button type="submit" class="btn btn-sm btn-primary pull-right"><?php __('Submit'); ?></button>
											</div><!-- // .panel-heading -->
											<div class="panel-body menu-structure" id="menu-structure">
												
												<ul class="menu-items menu-target">

													<?php $index = 0; ?>
													<li data-index="<?php echo $index; ?>">
														<input type="hidden" value="" name="items[<?php echo $index; ?>][parent]">
														<input type="hidden" value="" name="items[<?php echo $index; ?>][objectid]">
														<input type="hidden" value="" name="items[<?php echo $index; ?>][url]">
														<input type="hidden" value="" name="items[<?php echo $index; ?>][type]">
														<div class="portlet"><!-- /Basic Portlet -->
															<div class="portlet-heading">
																<div class="portlet-title">
																	<h4>Basic Portlet 1</h4>
																</div>
																<div class="portlet-widgets">
																	<a data-toggle="collapse" data-parent="#accordion" href="#panel_<?php echo $index; ?>"><i class="fa fa-chevron-down"></i></a>
																	<span class="divider"></span>
																	<a href="#" class="box-close" title="<?php __('Remove') ?>"><i class="fa fa-times text-danger"></i></a>
																</div>
																<div class="portlet-widgets">
																	<small class="text-sx"><?php __('Page') ?></small>
																</div>
																<div class="clearfix"></div>
															</div>
															<div id="panel_<?php echo $index; ?>" class="panel-collapse collapse">
																<div class="portlet-body form-horizontal" role="form">
																	<div class="row">
																		<div class="col-xs-12 col-sm-6">
																			<div class="form-group">
																				<label class="label-control"><?php __('Navigation label'); ?></label>
																				<input required type="text" value="" name="items[<?php echo $index; ?>][label]" class="form-control input-sm">
																			</div>
																		</div>
																		<div class="col-xs-12 col-sm-6">
																			<div class="form-group">
																				<label class="label-control"><?php __('Title attribute'); ?></label>
																				<input type="text" value="" name="items[<?php echo $index; ?>][title]" class="form-control input-sm">
																			</div>
																		</div>
																	</div><!-- // .row -->

																	<div class="form-group">
																		<label class="label-control"><?php __('CSS Classes (Optional)'); ?></label>
																		<input type="text" value="" name="items[<?php echo $index; ?>][css]" class="form-control input-sm">
																	</div>

																	<div class="form-group">
																		<label class="label-control"><?php __('Description'); ?></label>
																		<textarea name="items[<?php echo $index; ?>][description]" rows="4" class="form-control input-sm"></textarea>
																	</div>

																	<div class="form-group">
																		<label class="label-control"><?php __('Image'); ?></label>
																		<?php featured_image('items['.$index.'][image]', $index); ?>
																	</div>
																	

																	<div class="well white">
																		<?php __('Original:') ?> <a href="#">Original</a>
																	</div>

																</div><!-- // .portlet-body -->
															</div>
														</div><!-- /Basic Portlet -->

														<ul class="sub-items menu-target"></ul>
													</li>
													
												</ul><!-- // .menu-items -->

														

											</div><!-- // .panel-body -->
											<div class="panel-footer clearfix">
												<a href="#" class="btn-sm link" style="display:inline-block"><?php __('Delete menu') ?></a>
												<button type="submit" class="btn btn-primary btn-sm pull-right"><?php __('Submit'); ?></button>
											</div>
										</div><!-- // .panel -->
									</form>

								</div><!-- // structure -->
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