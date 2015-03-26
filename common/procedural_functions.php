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
// 					)
// 		,'cattegory'	=> true
// 		,'featured_image'=> true
// 		,'tag'	=> true
// 		,'template' => true
// 		,'searchable'=> true
// 	);

function register_post($args = array()){

	// check if array
	if (!is_array($args)) {
		return;
	}

	global $posts;

	// Prevent from overriding
	if (isset($posts[$args['id']])) {
		if (function_exists('register_admin_message')) {
			register_admin_message('Custom post', 'Can not register custom post, post already registered.', 'danger');
		}
		return;
	}

	// Add post
	$posts[$args['id']] = $args;

} // end of register_post()