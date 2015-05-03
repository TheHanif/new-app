<?php
/**
 * Prepare default capabilities
 */
$Users = new users();

// Site
$Users->register_capability('Site', 'Manage Pages');
$Users->register_capability('Site', 'Create Pages');
$Users->register_capability('Site', 'Publish Pages');
$Users->register_capability('Site', 'Edit Pages');
$Users->register_capability('Site', 'Delete Pages');
$Users->register_capability('Site', 'Manage Themes');

// Blog
// $Users->register_capability('Blog', 'Manage Blog');
// $Users->register_capability('Blog', 'Create Posts');
// $Users->register_capability('Blog', 'Edit Posts');
// $Users->register_capability('Blog', 'Publish Posts');
// $Users->register_capability('Blog', 'Delete Posts');
// $Users->register_capability('Blog', 'Manage Comments');

// Catalog
$Users->register_capability('Catalog', 'Manage catalog');
$Users->register_capability('Catalog', 'Manage products');
$Users->register_capability('Catalog', 'Add Products');
$Users->register_capability('Catalog', 'Edit Products');
$Users->register_capability('Catalog', 'Delete Products');
$Users->register_capability('Catalog', 'Manage Reviews');
$Users->register_capability('Catalog', 'Manage Payment Methods');
$Users->register_capability('Catalog', 'Manage Shipping Methods');
$Users->register_capability('Catalog', 'Manage Orders');
$Users->register_capability('Catalog', 'Edit Orders');
$Users->register_capability('Catalog', 'Delete Orders');
$Users->register_capability('Catalog', 'Manage Customers');

// Users
$Users->register_capability('Users', 'Manage Users');
$Users->register_capability('Users', 'Create Users');
$Users->register_capability('Users', 'Delete Users');
$Users->register_capability('Users', 'Manage Roles');

// Settings
$Users->register_capability('Settings', 'Manage Settings');

// Plugins
$Users->register_capability('Plugins', 'Manage Plugins');