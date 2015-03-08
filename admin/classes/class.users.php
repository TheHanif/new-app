<?php
class Users extends Database{

	public function __construct()
	{
		parent::__construct();
	}

	// Get login status
	public static function is_logged_in()
	{	
		if (isset($_SESSION['token'])) {
			return true;
		}else{
			return false;
		}
	}
}