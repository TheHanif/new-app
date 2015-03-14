<?php 
// Initialization
include_once 'include/init.php';

// Logout
if (isset($_GET['logout'])) {
  users::do_logout();
}

// Try to login
if (isset($_POST['submit'])) {
  $status = $Users->do_login($_POST);
  if (!$status) {
    $error_login = 'Incorrect Username or Password, please try again.';
  }
}

// Check if logged in
if (is_logged_in(false)) {

  // Redirection previous URL
  if (isset($_GET['URL'])) {
    header('location:'.urldecode($_GET['URL']));
    exit;
  }

  // Redirect to dashboard
  header('location:index.php');
}


?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php echo __('Login Form') , ' | ' , CMSNAME; ?></title>
  <link rel="stylesheet" href="assets/css/login.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
    <div class="login">
      <h1><?php echo __('Login'); ?></h1>
      <form method="post" action="login.php<?php echo (isset($_GET['URL']))? '?URL='.urlencode($_GET['URL']) : ''; ?>">
        <p><input type="text" name="login" value="" placeholder="<?php echo __('Username'); ?>"></p>
        <p><input type="password" name="password" value="" placeholder="<?php echo __('Password'); ?>"></p>
        
        <?php echo (isset($error_login))? '<p class="login-help error">'._($error_login).'</p>' : ''; ?>
        <!-- <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p> -->
        <p class="submit"><input type="submit" name="submit" value="<?php echo __('Login'); ?>"></p>
      </form>
    </div>
    <div class="login-help">
      <p><?php echo __('Forgot your password?'); ?> <a href="index.html"><?php echo __('Click here to reset it.'); ?></a></p>
    </div>
  </section>
</body>
</html>