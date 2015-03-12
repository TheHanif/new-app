<?php
// Admin absolute path
define('ADMINABS', ABSPATH.'admin/');

// CMS name
define('CMSNAME', 'New App');

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

// List of available capabilities
$capabilities_groups = array();
$capabilities_groups['Site'] 		= array(); // Manage pages
$capabilities_groups['Blog'] 		= array(); // Manage Blog
$capabilities_groups['Catalog'] 	= array(); // Manage Catalog
$capabilities_groups['Users'] 		= array(); // Manage Users
$capabilities_groups['Plugin'] 		= array(); // Manage Plugins
$capabilities_groups['Settings'] 	= array(); // Manage System Settings
