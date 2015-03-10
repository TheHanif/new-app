<!-- BEGIN SIDE NAVIGATION -->				
				<nav class="navbar-side" role="navigation">
					<div class="navbar-collapse sidebar-collapse collapse">
					
						<!-- BEGIN SHORTCUT BUTTONS -->
						<div class="media">							
							<ul class="sidebar-shortcuts">
								<li><a class="btn"><i class="fa fa-user icon-only"></i></a></li>
								<li><a class="btn"><i class="fa fa-envelope icon-only"></i></a></li>
								<li><a class="btn"><i class="fa fa-th icon-only"></i></a></li>
								<li><a class="btn"><i class="fa fa-gear icon-only"></i></a></li>
							</ul>	
						</div>
						<!-- END SHORTCUT BUTTONS -->	
							
						<!-- BEGIN FIND MENU ITEM INPUT -->
						<div class="media-search">	
							<input type="text" class="input-menu" id="input-items" placeholder="Find...">
						</div>						
						<!-- END FIND MENU ITEM INPUT -->
						
						<ul id="side" class="nav navbar-nav side-nav">
							<!-- BEGIN SIDE NAV MENU -->							
							<!-- Navigation category -->
							<li>
								<h4>Navigation</h4> 								
							</li>
							<!-- END Navigation category -->
							
							<?php 
							// Get Admin navigation
							generate_admin_menu(); ?>

						</ul><!-- /.side-nav -->
						
						<div class="sidebar-labels">
							<h4>Labels</h4>							
							<ul>
								<li><a href="#"><i class="fa fa-circle-o text-primary"></i> My Recent <span class="badge badge-primary">3</span></a></li>
								<li><a href="#"><i class="fa fa-circle-o text-success"></i> Background</a></li>
							</ul>
						</div>
						
						<div class="sidebar-alerts">							
							<div class="alert fade in">
								<span>Sales Report</span>
								<div class="progress progress-mini progress-striped active no-margin-bottom">
									<div class="progress-bar progress-bar-primary" style="width: 36%"></div>
								</div>
								<small>Calculating daily bias... 36%</small>
							</div>
						</div>
						
					</div><!-- /.navbar-collapse -->
				</nav><!-- /.navbar-side -->
				<!-- END SIDE NAVIGATION -->