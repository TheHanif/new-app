<?php

// Navigation after plugins menus
// This will loaded from load_active_plugins()

// Media
add_navigation_item('media', 'Media', 'camera', 'media.php', array('media_upload.php', 'media_edit.php'));

// Users
add_navigation_item('users', 'Users', 'users', '#', array(), NULL, HAS_USERS, array('Users'=>array('manage-users')));

// User submenu
add_navigation_item('users', 'Users', 'users', 'users.php', array(), 'users', NULL, array('Users'=>array('manage-users')));
add_navigation_item('create_user', 'Create user', 'plus', 'create_user.php', array(), 'users', NULL, array('Users'=>array('create-users')));
add_navigation_item('user_role', 'User roles', 'check', 'user_roles.php', array('create_role.php'), 'users', HAS_USERS_ROLE, array('Users'=>array('manage-roles')));



// Appereance
$appearance = array(
		'name' 				=> 	'appearance'
		,'title' 			=>	'Appearance'
		, 'icon' 			=>	'desktop'
		, 'capability'		=> 	array('Site'=>array('manage-appearance'))
	);
add_admin_menu_item($appearance);

$theme = array(
			'name' 				=> 	'theme'
			,'title' 			=>	'Themes'
			, 'icon' 			=>	'magic'
			, 'file'			=>	'themes.php'
			, 'parent'			=> 	'appearance'
			, 'capability'		=> array('Site'=>array('manage-themes'))
		);
add_admin_menu_item($theme);

$menu = array(
			'name' 				=> 	'menu'
			,'title' 			=>	'Menus'
			, 'icon' 			=>	'magic'
			, 'file'			=>	'menus.php'
			, 'parent'			=> 	'appearance'
			, 'capability'		=> array('Site'=>array('manage-menus'))
		);
add_admin_menu_item($menu);


// Plugins
$plugins = array(
		'name' 				=> 	'plugins'
		,'title' 			=>	'Plugins'
		, 'icon' 			=>	'plug'
		, 'file'			=>	'plugins.php'
		, 'capability'		=> 	array('Plugins'=>array('manage-plugins'))
	);
add_admin_menu_item($plugins);

// Settings
add_navigation_item('settings', 'Settings', 'cogs', 'settings.php', array(), NULL, NULL, array('Settings'=>array('manage-settings')));

// print_f($Users->user_capabilities, 1);
// print_f($admin_sidebar_navigation, 1);