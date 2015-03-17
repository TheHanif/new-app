<?php
class Capabilities extends Database{

	protected $role_table_name;
	protected $user_capabilities;

	// List of available capabilities
	protected $capabilities_group_container = array();

	public function __construct()
	{
		parent::__construct();

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
	 * Check if current user has these capabilities
	 */
	public function has_capabilities($capabilities = array())
	{	
		$state = false;

		// Provided capabilities must be an array
		if (!is_array($capabilities)) {
			register_admin_message('Capability error!', 'Provided capabilities must be an array', 'danger');
			return $state;
		}

		// Check through user's capabilities.
		foreach ($capabilities as $group_name => $group) {
			foreach ($group as $key => $value) {
				if (array_key_exists($group_name, $this->user_capabilities) && array_key_exists($value, $this->user_capabilities[$group_name])) {
					$state = true;
				}
			}
		}

		return $state;
	} // end of has_capabilities()

	/**
	 * Ger user's capabilities
	 */
	public function get_user_capabilitirs($user_id = NULL)
	{
		$profile = $this->get_profile($user_id);
		$role = $this->get_roles($profile->user_role);
		$role_capabilities_object = json_decode($role->role_object);

		// Convert to array
		$role_capabilities = array();
		foreach ($role_capabilities_object as $group_name => $group_data) {
			$role_capabilities[$group_name] = array();
			foreach ($group_data as $key => $value) {
				$role_capabilities[$group_name][$key] = $value;
			}
		}

		return $role_capabilities;
	} // end of get_user_capabilitirs()

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

	/**
	 * Delete role
	 * @param  integer $ID
	 */
	public function delete_role($ID)
	{
		$this->where('role_id', $ID);
		$this->delete($this->role_table_name, 1);
		return $this->row_count();
	} // end of delete_role()

	/**
	* Add new capabilty
	* @param  string $group
	* @param  string $key
	*/
	public function register_capability($group, $key)
	{
		if (isset($this->capabilities_group_container[$group])) {
			$this->capabilities_group_container[$group][str_replace(' ', '-', strtolower($key))] = $key;
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
} // end of class