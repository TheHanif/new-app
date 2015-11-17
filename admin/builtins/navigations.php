<?php
/**
 * Admin sidebar navigation
 */

//add_navigation_item($name, $title, $icon, $file, $child_files = array(), $parent = NULL, $settings = NULL, $capability = NULL)

// Dashboard
add_navigation_item('dashboard', 'Dashboard', 'dashboard', 'index.php');

// Pages
if (defined('HAS_PAGES') && HAS_PAGES == true) {

	$pages = array(
			'id' 		=>	'page'
			,'name'	=> 'Pages'
			,'meta'		=>	array(
						'title' => 'Page'
						,'single_title' => 'Page'
						,'pulural_title' => 'Pages'
						,'icon' => 'file-text'
						)
			,'attributes' => array('template', 'sidebar', 'parent')
			,'permalink'=> true
			,'content'=> true
			,'excerpt'=> true
			,'category'	=> false // no categories
			,'featured_image'=> 1
			,'tag'	=> false
			,'template' => true
			,'searchable'=> true
		);

	register_post($pages); // end pages
} // end pages

// Blog
if (defined('HAS_BLOG') && HAS_BLOG == true) {
	$blog = array(
			'id' 		=>	'blog'
			,'name'	=> 'Blog'
			,'meta'		=>	array(
						'title' => 'Post'
						,'single_title' => 'Post'
						,'pulural_title' => 'Posts'
						,'icon' => 'thumb-tack'
						)
			,'attributes' => array()
			,'permalink'=> true
			,'content'=> true
			,'excerpt'=> true
			,'category'	=> true
			,'featured_image'=> 1
			,'tag'	=> false
			,'template' => true
			,'searchable'=> true
		);

	register_post($blog); // end Blog
} // end blog


// Catalog
if (defined('HAS_CATALOG') && HAS_CATALOG == true) {
	include 'catalog_nav.php';
} // end catalog menu

// Media
add_navigation_item('media', 'Media', 'camera', 'media.php', array('media_upload.php', 'media_edit.php'));

// Users
add_navigation_item('users', 'Users', 'users', '#', array(), NULL, HAS_USERS, array('Users'=>array('manage-users')));

// User submenu
add_navigation_item('users', 'Users', 'users', 'users.php', array(), 'users', NULL, array('Users'=>array('manage-users')));
add_navigation_item('create_user', 'Create user', 'plus', 'create_user.php', array(), 'users', NULL, array('Users'=>array('create-users')));
add_navigation_item('user_role', 'User roles', 'check', 'user_roles.php', array('create_role.php'), 'users', HAS_USERS_ROLE, array('Users'=>array('manage-roles')));

// Settings
add_navigation_item('settings', 'Settings', 'cogs', 'settings.php', array(), NULL, NULL, array('Settings'=>array('manage-settings')));

// print_f($Users->user_capabilities, 1);
// print_f($admin_sidebar_navigation, 1);