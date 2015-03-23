<?php 
// Initialization
include_once 'include/init.php';

$Media = new media();

if (isset($_POST['submit'])) {

	$status = 1;
	foreach ($_FILES['media']['name'] as $key => $value) {
		$file = array();
		$file['name'] = $_FILES['media']['name'][$key];
		$file['type'] = $_FILES['media']['type'][$key];
		$file['tmp_name'] = $_FILES['media']['tmp_name'][$key];
		$file['error'] = $_FILES['media']['error'][$key];
		$file['size'] = $_FILES['media']['size'][$key];
		if(!$Media->upload_media($file)){
			$status = 0;
		}
	}
header('location:media.php');
exit;
	if ($status == 0) {
		register_admin_message('Error uploading', 'Some of your file are not uploaded', 'danger');
	}

	get_messages();
}