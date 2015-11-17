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

/**
 * Get available query strings
 * @return array
 */
function get_query_string()
{
	if (empty($_SERVER['QUERY_STRING'])) {
		return;
	}

	$query_strings = $_SERVER['QUERY_STRING'];

	// Create array if more then 1 query
	if (strpos($query_strings, '&') != false) {
		$query_strings = explode('&', $query_strings);
	}

	// Sub array
	$params = array();

	// Loop if more then 1 query
	if (is_array($query_strings)) {
		foreach ($query_strings as $value) {
			$string_data = explode('=', $value);
			$params[$string_data[0]] = $string_data[1];
		}
	}else{
		// If 1 query
		$string_data = explode('=', $query_strings);
		$params[$string_data[0]] = $string_data[1];
	}

	return $params;
}

/**
 * Register media size
 * @param  array  $new_size
 * 
 * array(
 *		'key' => 'medium'
 *		,'description' => 'Medial'
 *		, 'crop' => false
 *	)
 */
function register_media_size($new_size = array()){
	global $media_sizes;
	$media_sizes[] = $new_size;
} // end of register_media_size()

function get_media_sizes(){
	global $media_sizes;
	return $media_sizes;
}