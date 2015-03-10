<?php
/**
 * Admin sidebar navigation
 */

// Dashboard
add_navigation_item('dashboard', 'Dashboard', 'dashboard', 'index.php');

// Users
add_navigation_item('users', 'Users', 'users', '#', NULL, HAS_USERS);

// User submenu
add_navigation_item('users', 'Users', 'users', 'users.php', 'users', NULL, HAS_USERS);
add_navigation_item('create_user', 'Create user', 'plus', 'create_user.php', 'users', NULL, HAS_USERS);
add_navigation_item('user_role', 'User roles', 'check', 'user_roles.php', 'users', NULL, HAS_USERS);


// Settings
add_navigation_item('settings', 'Settings', 'cogs', 'settings.php');