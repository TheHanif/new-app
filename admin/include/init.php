<?php
session_start();

// Load database details
include_once '../config.php';

// Load site functionality vars
include_once ABSPATH.'common/settings.php';

// Load database class
include_once ABSPATH.'include/class.database.php';

// Load default vars
include_once ABSPATH.'common/default_vars.php';

// Admin only Prosedural functions
include_once ADMINABS.'include/procedural_functions.php';

// Prosedural functions
include_once ABSPATH.'common/procedural_functions.php';

// Load admin classes
spl_autoload_register('admin_autoloader');

// Redirect to login page if not logged in
is_logged_in(true);

// Load default capabilities list
include_once ADMINABS.'builtins/capabilities.php';

// Load Built-in features
include_once ADMINABS.'builtins/navigations.php';