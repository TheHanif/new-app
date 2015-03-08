<?php 
// Initialization
include_once 'include/init.php';
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
      <form method="post" action="index.html">
        <p><input type="text" name="login" value="" placeholder="<?php echo _('Username or Email'); ?>"></p>
        <p><input type="password" name="password" value="" placeholder="<?php echo _('Password'); ?>"></p>
        <!-- <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p> -->
        <p class="submit"><input type="submit" name="commit" value="<?php echo _('Login'); ?>"></p>
      </form>
    </div>

    <div class="login-help">
      <p><?php echo _('Forgot your password?'); ?> <a href="index.html"><?php echo _('Click here to reset it.'); ?></a></p>
    </div>
  </section>

</body>
</html>
