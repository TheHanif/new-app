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


// After this, it will load menus from plugins. Then second part of admin default menu from navigations_second.php
// use second part to add menu