<?php
session_start();

include_once '../../config.php';

define('ADMINABS', ABSPATH.'admin/');

include_once ABSPATH.'include/class.database.php';
include_once ADMINABS.'include/procedural_functions.php';

$Media = new media();

if (isset($_POST['action'])) {
	
	// browse
	if ($_POST['action'] == 'browse') {
		echo json_encode($Media->get_media());
	}
}