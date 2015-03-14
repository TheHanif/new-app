<?php
class Users extends Database{

	private $table_name;
	private $profile_table_name;
	private $role_table_name;

	// List of available capabilities
	private $capabilities_group_container = array();

	public function __construct()
	{
		parent::__construct();
		$this->table_name = DB_PREFIX.'users';
		$this->profile_table_name = DB_PREFIX.'user_profiles';
		$this->role_table_name = DB_PREFIX.'user_roles';

		// prepare capabilities group
		$this->capabilities_group_container['Site'] 		= array(); // Manage pages
		$this->capabilities_group_container['Blog'] 		= array(); // Manage Blog
		$this->capabilities_group_container['Catalog'] 		= array(); // Manage Catalog
		$this->capabilities_group_container['Users'] 		= array(); // Manage Users
		$this->capabilities_group_container['Plugins'] 		= array(); // Manage Plugins
		$this->capabilities_group_container['Settings'] 	= array(); // Manage System Settings
	}

	/**
	 * Save or update role
	 * @param  string  $title               Title
	 * @param  string  $description         Role description
	 * @param  array   $capabilities_groups Data
	 * @param  integer $ID                  Role ID. if parsed, updated existing
	 * @return integer                      Updated row count
	 */
	public function save_role($title, $description, $capabilities_groups, $ID = NULL)
	{
		$capabilities_groups = json_encode($capabilities_groups);

		// Prepare columns
		$data = array();
		$data['role_title'] = $title;
		$data['role_object'] = $capabilities_groups;
		$data['role_description'] = $description;

		if (isset($ID)) {
			// Update old
			$this->where('role_id', $ID);
			$this->update($this->role_table_name, $data);
		}else{
			// Insert new
			$this->insert($this->role_table_name, $data);
		}

		return $this->row_count();
	} // end of save_role()

	/**
	 * Get roles
	 * @param  integer $ID
	 * @return objects
	 */
	public function get_roles($ID = NULL)
	{
		if (isset($ID)) {
			$this->where('role_id', $ID);
		}

		$this->from($this->role_table_name);

		if ($this->row_count() > 0 && isset($ID)) {
			return $this->result();
		}elseif ($this->row_count() > 0) {
			return $this->all_results();
		}
	}// end of get_roles()

	public function delete_role($ID)
	{
		$this->where('role_id', $ID);
		$this->delete($this->role_table_name, 1);
		return $this->row_count();
	}

	/**
	* Add new capabilty
	* @param  string $group
	* @param  string $key
	*/
	public function register_capability($group, $key)
	{
		if (isset($this->capabilities_group_container[$group])) {
			$this->capabilities_group_container[$group][str_replace(' ', '-', $key)] = $key;
		}else{
			register_admin_message('Capabilty not registered', 'Invalid capabilty group.', 'danger');
		}
	} // end of register_capability()

	/**
	 * Get Capabilities Group
	 */
	public function get_capabilities_groups()
	{
		return $this->capabilities_group_container;
	} // end of get_capabilities_groups()

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
	public function get_profile($user_id)
	{
		$this->where('user_id', $user_id);
		$this->from($this->profile_table_name);
		if ($this->row_count() > 0) {
			return $this->result();
		}
	} // end of get_profile()
} // end of class