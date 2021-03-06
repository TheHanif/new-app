<?php
// Admin absolute path
define('ADMINABS', ABSPATH.'admin/');

// Contents path
define('CONTPATH', ABSPATH.'contents/');

// CMS name
define('CMSNAME', 'New App');

define('SITEURL', 'http://new-app:8888/');
define('ADMINDIRNAME', 'admin');

define('ADMINURL', SITEURL.ADMINDIRNAME.'/');

// Contents URL
define('CONTURL', SITEURL.'contents/');

define('MEGAMENUSTEPS', 5);



// Admin page title
$admin_title = 'Untitled';

// Language object
$lang = NULL; // Used in procedural functions

// Admin sidebar navigation
$admin_sidebar_navigation = array();

// Admin messages and notifications
$messages = array();

// User can serve the page if false
// Handled from generate_admin_menu() active page sections
// If current requested page is active item in menu, all the settings and capabilities will verified
$lock_page = true;

// Registered posts
$posts = array();

// Media sizes
$media_sizes = array();