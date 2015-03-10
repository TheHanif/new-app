<?php
/**
 * Admin sidebar navigation
 */

// Dashboard
add_navigation_item('dashboard', 'Dashboard', 'dashboard', 'index.php');

// Users
add_navigation_item('users', 'Users', 'users', '#');

// User submenu
add_navigation_item('users', 'Users', 'users', 'users.php', 'users');
add_navigation_item('create_user', 'Create user', 'plus', 'create_user.php', 'users');
add_navigation_item('user_role', 'User roles', 'check', 'user_roles.php', 'users');


// Settings
add_navigation_item('settings', 'Settings', 'cogs', 'settings.php');