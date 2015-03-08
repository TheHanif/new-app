<?php 
// Initialization
include_once 'include/init.php';

if (is_logged_in(false)) {

  // Redirection previous URL
  if (isset($_GET['URL'])) {
    header('location:'.urldecode($_GET['URL']));
    exit;
  }

  // Redirect to dashboard
  header('location:index.php');
}

$user = new users();

if (isset($_POST['submit'])) {
  print_f($_POST);
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
  <title><?php echo _('Login Form') , ' | ' , CMSNAME; ?></title>
  <link rel="stylesheet" href="assets/css/login.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
    <div class="login">
      <h1><?php echo _('Login'); ?></h1>
      <form method="post" action="login.php<?php echo (isset($_GET['URL']))? '?url='.urlencode($_GET['URL']) : ''; ?>">
        <p><input type="text" name="login" value="" placeholder="<?php echo _('Username'); ?>"></p>
        <p><input type="password" name="password" value="" placeholder="<?php echo _('Password'); ?>"></p>
        
        <p class="login-help error"><?php echo (isset($error_login))? _($error_login) : ''; ?></p>
        <!-- <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p> -->
        <p class="submit"><input type="submit" name="submit" value="<?php echo _('Login'); ?>"></p>
      </form>
    </div>
    <div class="login-help">
      <p><?php echo _('Forgot your password?'); ?> <a href="index.html"><?php echo _('Click here to reset it.'); ?></a></p>
    </div>
  </section>
</body>
</html>
