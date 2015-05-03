<?php 
/**
 * Catalog navigation
 */

// function add_navigation_item($name, $title, $icon, $file, $child_files = array(), $parent = NULL, $settings = NULL, $capability = NULL)

// Catalog TL
add_navigation_item('catalog', 'Catalog', 'shopping-cart', '#', array(), NULL, HAS_CATALOG, array('Catalog'=>array('manage-catalog')));

/**
 * Products
 */
add_navigation_item('products', 'Products', 'barcode', '#', array(), 'catalog', HAS_CATALOG, array('Catalog'=>array('manage-products')));

/**
 * Sections
 */
add_navigation_item('sections', 'Sections', 'list', '#', array(), 'catalog', HAS_CATALOG, array('Catalog'=>array('manage-products')));

/**
 * Manufacturers
 */
add_navigation_item('manufacturers', 'Manufacturers', 'check', '#', array(), 'catalog', HAS_CATALOG, array('Catalog'=>array('manage-products')));

/**
 * Downloads
 */
add_navigation_item('download', 'Downloads', 'download', '#', array(), 'catalog', HAS_CATALOG, array('Catalog'=>array('manage-products')));

/**
 * Options
 */
add_navigation_item('options', 'Options', 'tasks', '#', array(), 'catalog', HAS_CATALOG, array('Catalog'=>array('manage-products')));

/**
 * Attributes
 */
add_navigation_item('attributes', 'Attributes', 'th', '#', array(), 'catalog', HAS_CATALOG, array('Catalog'=>array('manage-products')));

/**
 * Sales
 */
add_navigation_item('sales', 'Sales', 'money', '#', array(), 'catalog', HAS_CATALOG, array('Catalog'=>array('manage-products')));

/**
 * Methods
 */
add_navigation_item('methods', 'Methods', 'plug', '#', array(), 'catalog', HAS_CATALOG, array('Catalog'=>array('manage-products')));




?>