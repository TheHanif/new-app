<?php
// Admin absolute path
define('ADMINABS', ABSPATH.'admin/');

// CMS name
define('CMSNAME', 'New App');

define('SITEURL', 'http://localhost/new-app/');

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