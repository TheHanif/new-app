<?php 
// Redirect to login page if not logged in
is_logged_in(true);

// Load Plugins
load_active_plugins();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo __($admin_title) , ' | ' , CMSNAME; ?></title>
	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fonts.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	
	<!-- PAGE LEVEL PLUGINS STYLES -->
	<link rel="stylesheet" href="assets/css/plugins/colorBox/colorbox.css">

	<!-- REQUIRE FOR SPEECH COMMANDS -->
	<link rel="stylesheet" type="text/css" href="assets/css/plugins/gritter/jquery.gritter.css" />	

    <!-- Tc core CSS -->
	<link id="qstyle" rel="stylesheet" href="assets/css/themes/style.css">	
	<!--[if lte IE 8]>
		<link rel="stylesheet" href="assets/css/ie-fix.css" />
	<![endif]-->
	
	
    <!-- Add custom CSS here -->

	<!-- End custom CSS here -->
	
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
	<style>
	.navbar-brand{
		padding: 6px;
	}

	.bootbox-close-button{
		margin-bottom: -11px;/*remove bottom margin of media browse*/
	}

	#SampleDT th:first-child::after, #SampleDT th:last-child::after, .no-data::after{
		display: none;
	}

	.qs-layout-menu{
		z-index: 10000;
		margin-top: 11px;
	}
	</style>
	<link rel="stylesheet" href="assets/css/plugins/bootstrap-wysihtml/bootstrap-wysihtml5.css">
	<link href="assets/css/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
  </head>

  <body>

  <!-- /#ek-layout-button -->	
	<div class="qs-layout-menu">
		<div class="btn btn-gray qs-setting-btn" id="qs-setting-btn">
			<i class="fa fa-cog bigger-150 icon-only"></i>
		</div>
		<div class="qs-setting-box" id="qs-setting-box">
		
			<div class="hidden-xs hidden-sm">
				<span class="bigger-120">Layout Options</span>
				
				<div class="hr hr-dotted hr-8"></div>
				<label>
					<input type="checkbox" class="tc" id="fixed-navbar" />
						<span id="#fixed-navbar" class="labels"> Fixed NavBar</span>
				</label>
				<label>
					<input type="checkbox" class="tc" id="fixed-sidebar" />
						<span id="#fixed-sidebar" class="labels"> Fixed NavBar+SideBar</span>
				</label>
				<label>
					<input type="checkbox" class="tc" id="sidebar-toggle" />
						<span id="#sidebar-toggle" class="labels"> Sidebar Toggle</span>
				</label>
				<label>
					<input type="checkbox" class="tc" id="in-container" />
						<span id="#in-container" class="labels"> Inside<strong>.container</strong></span>
				</label>
			
				<div class="space-4"></div>
			</div>
			
			<span class="bigger-120">Color Options</span>
			
			<div class="hr hr-dotted hr-8"></div>
			
			<label>
				<input type="checkbox" class="tc" id="side-bar-color" />
				<span id="#side-bar-color" class="labels"> SideBar (Light)</span>
			</label>
			
			<ul>									
				<li><button class="btn" style="background-color:#d15050;" onclick="swapStyle('assets/css/themes/style.css')"></button></li>
				<li><button class="btn" style="background-color:#86618f;" onclick="swapStyle('assets/css/themes/style-1.css')"></button></li> 
				<li><button class="btn" style="background-color:#ba5d32;" onclick="swapStyle('assets/css/themes/style-2.css')"></button></li>
				<li><button class="btn" style="background-color:#488075;" onclick="swapStyle('assets/css/themes/style-3.css')"></button></li>
				<li><button class="btn" style="background-color:#4e72c2;" onclick="swapStyle('assets/css/themes/style-4.css')"></button></li>
			</ul>
			
		</div>
	</div>
	<!-- /#ek-layout-button -->

	<div id="wrapper">
		<div id="main-container">		
			<!-- BEGIN TOP NAVIGATION -->
				<nav class="navbar-top" role="navigation">
					<!-- BEGIN BRAND HEADING -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".top-collapse">
							<i class="fa fa-bars"></i>
						</button>
						<div class="navbar-brand">
							<a href="index.html">
								<img src="assets/images/main-logo.png" alt="logo" class="img-responsive">
							</a>
						</div>
					</div>
					<!-- END BRAND HEADING -->
					<div class="nav-top">
						<!-- BEGIN RIGHT SIDE DROPDOWN BUTTONS -->
							<ul class="nav navbar-right">					
								<li class="dropdown">
									<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
										<i class="fa fa-bars"></i>
									</button>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-envelope"></i> <span class="badge up badge-primary">2</span>
									</a>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-bell"></i> <span class="badge up badge-success">3</span>
									</a>
								</li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<i class="fa fa-tasks"></i> <span class="badge up badge-info">7</span>
									</a>
								</li>
								<!--Speech Icon-->
								<li class="dropdown">
									<a href="#" class="speech-button">
										<i class="fa fa-microphone"></i>
									</a>
								</li>
								<!--Speech Icon-->
								
								<li class="dropdown user-box">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<img class="img-circle" src="assets/images/user.jpg" alt=""> <span class="user-info">John Smith</span> <b class="caret"></b>
									</a>
									<ul class="dropdown-menu dropdown-user">
										<li>
											<a href="create_user.php?update=profile">
												<i class="fa fa-user"></i> <?php __('Edit Profile'); ?>
											</a>
										</li>
										<li>
												<a href="#">
													<i class="fa fa-envelope"></i> My Messages
												</a>
											</li>
											<li>
												<a href="#">
													<i class="fa fa-tasks"></i> My Tasks
												</a>
											</li>
											<li>
												<a href="settings.php">
													<i class="fa fa-gear"></i> <?php __('Settings') ?>
												</a>
											</li>											
											<li>
												<a href="login.php?logout">
													<i class="fa fa-power-off"></i> <?php __('Logout') ?>
												</a>
											</li>
									</ul>
								</li>
								<!--Search Box-->
								<li class="dropdown nav-search-icon">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<span class="glyphicon glyphicon-search"></span>
									</a>
									<ul class="dropdown-menu dropdown-search">
										<li>
											<div class="search-box">
												<form class="" role="search">
													<input type="text" class="form-control" placeholder="Search" />
												</form>
											</div>
										</li>
									</ul>
								</li>
								<!--Search Box-->
								
							</ul>
						<!-- END RIGHT SIDE DROPDOWN BUTTONS -->							
						<!-- BEGIN TOP MENU -->
							<div class="collapse navbar-collapse top-collapse">
								<!-- .nav -->
								<ul class="nav navbar-left navbar-nav">
									<li><a href="index.php"><?php __('Dashboard') ?></a></li>
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown">
											Pages <b class="caret"></b>
										</a>
										<ul class="dropdown-menu">
											<li> <a href="pricing.html">Pricing</a></li>
										</ul>
									</li>
									<li><a href="<?php echo SITEURL; ?>">FrontEnd</a></li>
								</ul><!-- /.nav -->
							</div>
						<!-- END TOP MENU -->
					</div><!-- /.nav-top -->
				</nav><!-- /.navbar-top -->
				<!-- END TOP NAVIGATION -->

				
				<!-- BEGIN SIDE NAVIGATION -->				
				<?php include 'sidebar.php'; ?>
				<!-- END SIDE NAVIGATION -->
				

				