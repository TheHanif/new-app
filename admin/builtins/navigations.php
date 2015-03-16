<?php
/**
 * Admin sidebar navigation
 */

// Dashboard
add_navigation_item('dashboard', 'Dashboard', 'dashboard', 'index.php');

// Users
add_navigation_item('users', 'Users', 'users', '#', array(), NULL, HAS_USERS, array('Users'=>array('manage-users')));

// User submenu
add_navigation_item('users', 'Users', 'users', 'users.php', array(), 'users', NULL, array('Users'=>array('manage-users')));
add_navigation_item('create_user', 'Create user', 'plus', 'create_user.php', array(), 'users', NULL, array('Users'=>array('create-users')));
add_navigation_item('user_role', 'User roles', 'check', 'user_roles.php', array('create_role.php'), 'users', HAS_USERS_ROLE, array('Users'=>array('manage-roles')));


// Settings
add_navigation_item('settings', 'Settings', 'cogs', 'settings.php', array(), NULL, NULL, array('Settings'=>array('manage-settings')));

//add_navigation_item($name, $title, $icon, $file, $child_files = array(), $parent = NULL, $settings = NULL, $capability = NULL)