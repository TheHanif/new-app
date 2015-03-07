<?php
// Load database details
include_once '../config.php';

// Load site functionality vars
include_once ABSPATH.'common/settings.php';

// Load default vars
include_once ABSPATH.'common/default_vars.php';

// Load database class
include_once ABSPATH.'include/class.database.php';

// Custom auto loader
function class_autoloader($class) {
    include_once ADMINABS.'classes/class.' . $class . '.php';
}

// Register custom auto loader as > php 5.1.2
spl_autoload_register('class_autoloader');

// Language object
$lang = new language();

// Translator functions
function _($key)
{	
	global $lang;
	return $lang->get_key($key);
}