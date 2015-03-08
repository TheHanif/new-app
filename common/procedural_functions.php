<?php
// Custom auto loader
function class_autoloader($class) {
    include_once ADMINABS.'classes/class.' . $class . '.php';
}

// Register custom auto loader as > php 5.1.2
spl_autoload_register('class_autoloader');


/**
 * Translator function
 * 
 * @param string $key Language key
 */
$lang = new language();

function _($key)
{	
	global $lang;
	return $lang->get_key($key);
}