<?php
/**
 * Procedural Functiobs for Admin and Front end
 */

/**
 * Register custom post
 * @param array $args Post features
 */

// $args = array(
// 		'id' 		=>	'blog'
// 		,'title'	=> 'Blog'
// 		,'meta'		=>	array(
// 					'title' => 'Post'
// 					,'single_title' => 'post'
// 					,'pulural_title' => 'Posts'
//					,'icon' => 'thumb-tack'
// 					)
// 		,'category'	=> true
// 		,'featured_image'=> true
// 		,'tag'	=> true
// 		,'template' => true
// 		,'searchable'=> true
// 	);

function register_post($args = array()){
	global $Users;
	extract($args);
	
	// check if array
	if (!is_array($args)) {
		return;
	}

	global $posts;

	// Prevent from overriding
	if (isset($posts[$id])) {
		if (function_exists('register_admin_message')) {
			register_admin_message('Custom post', 'Can not register custom post, post already registered.', 'danger');
		}
		return;
	}

	// Register capaboloties for custom
	$Users->register_capability($id, 'Manage', true);
	$Users->register_capability($id, 'Create', true);
	$Users->register_capability($id, 'Publish', true);
	$Users->register_capability($id, 'Edit', true);
	$Users->register_capability($id, 'Delete', true);

	// Add post
	$posts[$id] = $args;

	// Main Item
	add_navigation_item($id, $name, $meta['icon'], '#', array(), NULL, NULL, array($id=>array('manage')));
	
	add_navigation_item('all'.$id, 'All '.$meta['pulural_title'], $meta['icon'], 'posts.php?type='.$id, array(), $id, NULL, NULL);
	add_navigation_item('new'.$id, 'New '.$meta['title'], 'plus', 'post_create.php?type='.$id, array(), $id, NULL, array($id=>array('create')));
	
	// Add category item
	if(isset($category) && $category == true)
	add_navigation_item('categories', 'Categories', 'list', 'categories.php?type='.$id, array('category_create.php'), $id, NULL, NULL);
	
	// Add tag item
	if(isset($tag) && $tag == true)
	add_navigation_item('tag', 'Tags', 'th', 'tags.php?type='.$id, array('tag_create.php'), $id, NULL, NULL);

} // end of register_post()
// add_navigation_item($name, $title, $icon, $file, $child_files = array(), $parent = NULL, $settings = NULL, $capability = NULL)