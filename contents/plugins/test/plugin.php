<?php
/*
Name: Test theme
Author: Muhammad Hanif
Version: 1.0
Description: Test Description of the theme

URL: http://google.com
*/


// print_f($Users->get_capabilities_groups());

// Plugins
$HANIF = array(
		'name' 				=> 	'HANIF'
		,'title' 			=>	'HANIF'
		, 'icon' 			=>	'desktop'
		, 'file'			=>	'plugins.php'
		, 'capability'		=> 	array('Plugins'=>array('manage-plugins'))
	);
add_admin_menu_item($HANIF);