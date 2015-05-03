<?php 
/**
 * Catalog navigation
 */

// function add_navigation_item($name, $title, $icon, $file, $child_files = array(), $parent = NULL, $settings = NULL, $capability = NULL)

// Catalog TL
add_navigation_item('catalog', 'Catalog', 'shopping-cart', '#', array(), NULL, HAS_CATALOG, array('Catalog'=>array('manage-catalog')));


?>