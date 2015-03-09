<?php
// Custom auto loader
function class_autoloader($class) {
    include_once ADMINABS.'classes/class.' . $class . '.php';
}

// Register custom auto loader as > php 5.1.2
spl_autoload_register('class_autoloader');


/**
 * Translator function
 * 
 * @param string $key Language key
 */
$lang = new language();

function __($key)
{	
	global $lang;
	return $lang->get_key($key);
}

// Alternate of print_r
function print_f($data, $exit = false)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';

	if($exit) exit;
}

// Get current URL from address bar
function get_actual_url()
{
	$actual_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return urlencode($actual_url);
}

/**
 * Check user login status
 * 
 * @param boolean $redirect
 */
function is_logged_in($redirect = false)
{
	$status = Users::is_logged_in();

	// $URL = (isset($_GET['URL']))? urlencode($_GET['URL']) : get_actual_url();

	if (!$status && $redirect) {
		header("location:login.php?URL=".get_actual_url());
	}

	return $status;
}

/**
 * Get requested file name
 * @return string
 */
function get_script_name()
{
	return end(explode('/', rtrim($_SERVER['SCRIPT_NAME'], '.php')));
}

function is_page_active($page, $echo = true)
{	
	if ($page == get_script_name()) {
		if ($echo) {
			echo "active";
		}else{
			return 'active';
		}
	}
}