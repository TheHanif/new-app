<?php
class Users extends Capabilities{

	public $table_name;
	private $profile_table_name;

	public function __construct()
	{
		parent::__construct();
		$this->table_name = DB_PREFIX.'users';
		$this->profile_table_name = DB_PREFIX.'user_profiles';
		
		// Get capabilities for current logged user
		if ($this->is_logged_in()) {
			$this->user_capabilities = $this->get_user_capabilitirs();
		}

	} // end of __construct()

	/**
	 * Delete user
	 */
	public function delete_user($user_id)
	{
		$this->where('user_id', $user_id);
		$this->delete($this->profile_table_name,1);

		if($this->row_count() > 0){
			$this->where('user_id', $user_id);
			$this->delete($this->table_name,1);
		}

		return $this->row_count();
	}

	/**
	 * Get all users
	 */
	public function get_users()
	{
		$this->from($this->table_name);
		return $this->all_results();
	}

	public function save_user($data, $user_ID = NULL)
	{
		extract($data);

		// User
		$user_data = array();

		if (isset($password)) {
			// Check for old password
			if (isset($user_ID) && isset($old_password)) {
				$this->where('user_password', md5($old_password));
				$this->where('user_id', $user_ID);
				$this->select(array('user_id'=>'user_id'));
				$this->from($this->table_name);
				if ($this->row_count() <= 0){
					register_admin_message('Incorrect Password', 'Please enter valid existing password.', 'danger');
					return false;
				}
			}

			// Match passwords
			if ($password1 != $password2) {
				register_admin_message('Password Mismatch', 'New password and confirm new password does not match.', 'danger');
				return false;
			}
			
			$user_data['user_password'] = md5($password1);
		}

		// User data
		if (isset($user_ID)) {
			// Update old
			if (isset($password)) {
				$this->where('user_id', $user_ID);
				$this->update($this->table_name, $user_data);
			}
		}else{
			// Insert new
			$user_data['user_username'] = $username;
			$this->insert($this->table_name, $user_data);
			$new_user_id = $this->last_id();
		}

		$profile_data = array();
		$profile_data['user_name'] = $name;
		$profile_data['user_display_name'] = $display_name;
		$profile_data['user_email'] = $email;
		$profile_data['user_image'] = 'image';
		$profile_data['user_role'] = $role;

		// User Profile
		if (isset($user_ID)) {
			// Update old
			$this->where('user_id', $user_ID);
			$this->update($this->profile_table_name, $profile_data);
		}else{
			// Insert new
			$profile_data['user_id'] = $new_user_id;
			$this->insert($this->profile_table_name, $profile_data);
		}

		return 1;
	}

	// Get login status
	public static function is_logged_in()
	{	
		if (isset($_SESSION['token'])) {
			return true;
		}else{
			return false;
		}
	} // end of is_logged_in()

	/**
	 * Login user
	 * @param  array $info submited form data
	 * @return boolean
	 */
	public function do_login($info)
	{	
		// Filter password
		$password = md5($info['password']);

		// Prepare where statement
		$this->where('user_username', $info['login']);
		$this->where('user_password', $password);

		// Select user primary key
		$this->select(array('user_id'=>'user_id'));

		// From table
		$this->from($this->table_name);

		// If provided info is correct, login user
		if ($this->row_count() > 0) {
			
			$results = $this->result();

			$_SESSION['token'] = time();
			$_SESSION['user_id'] = $results->user_id;

			return true;
		}else{
			return false;
		}
	} // end of do_login()

	/**
	 * Logout user remove session
	 * @return boolean
	 */
	public static function do_logout()
	{	
		if (isset($_SESSION['token'])) {
			unset($_SESSION['user_id']);
			unset($_SESSION['token']);
			return true;
		}
	} // end of do_logout()

	/**
	 * Get primary key of logged user
	 * @return int
	 */
	public static function get_logged_id()
	{
		if (isset($_SESSION['user_id'])) {
			return $_SESSION['user_id'];
		}
	} // end of get_logged_id()

	/**
	 * Get user profile detail
	 * @param  int $user_id
	 * @return object
	 */
	public function get_profile($user_id = NULL)
	{
		if (is_null($user_id)) {
			$user_id = $this->get_logged_id();
		}

		$this->where('user_id', $user_id);
		$this->from($this->profile_table_name);
		if ($this->row_count() > 0) {
			return $this->result();
		}
	} // end of get_profile()
} // end of class