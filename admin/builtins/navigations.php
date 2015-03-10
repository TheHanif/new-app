<?php
/**
 * Admin sidebar navigation
 */
$dashboard = array(
		'title' => 'Dashboard'
		,'icon' => 'dashboard'
		,'file' => 'index.php'
	);
$admin_sidebar_navigation['dashboard'] = $dashboard;

$sample = array(
		'title' => 'Sample'
		,'icon' => 'twitter'
		,'file' => 'javascript:;'
		,'submenu' => array(
				'facebook' => array(
						'title' => 'Facebook'
						,'icon' => 'facebook'
						,'file' => 'facebook.php'
					) // end item
			) // end submenu
	); // end menu item
$admin_sidebar_navigation['sample'] = $sample;