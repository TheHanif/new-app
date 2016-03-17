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
	</style>
	<link rel="stylesheet" href="assets/css/plugins/bootstrap-wysihtml/bootstrap-wysihtml5.css">
	<link href="assets/css/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
  </head>

  <body>
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
													<i class="fa fa-gear"></i> Settings
												</a>
											</li>											
											<li>
												<a href="login.php?logout">
													<i class="fa fa-power-off"></i> Logout
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
									<li><a href="index.php">Dashboard</a></li>
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
				

				