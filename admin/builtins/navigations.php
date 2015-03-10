<?php
/**
 * Admin sidebar navigation
 */

// Dashboard
$dashboard = array(
		'title' => 'Dashboard'
		,'icon' => 'dashboard'
		,'file' => 'index.php'
	);
$admin_sidebar_navigation['dashboard'] = $dashboard;

// Users
$users = array(
		'title' => 'Users'
		,'icon' => 'users'
		,'file' => 'javascript:;'
		,'submenu' => array(
				'users' => array(
						'title' => 'Users'
						,'icon' => 'users'
						,'file' => 'users.php'
					) // end item
				,'create_user' => array(
						'title' => 'Create user'
						,'icon' => 'plus'
						,'file' => 'create_user.php'
					) // end item
				,'user_roles' => array(
						'title' => 'User role'
						,'icon' => 'check'
						,'file' => 'user_roles.php'
					) // end item
			) // end submenu
	); // end menu item
$admin_sidebar_navigation['users'] = $users;

// Settings
$settings = array(
		'title' => 'Settings'
		,'icon' => 'cogs'
		,'file' => 'settings.php'
	);
$admin_sidebar_navigation['settings'] = $settings;


/// Sample
$sample = array(
		'title' => 'Sample'
		,'icon' => 'twitter'
		,'file' => 'javascript:;'
		,'submenu' => array(
				'facebook' => array(
						'title' => 'Facebook'
						,'icon' => 'facebook'
						,'file' => 'facebook.php'
					) // end item
			) // end submenu
	); // end menu item
$admin_sidebar_navigation['sample'] = $sample;