<?php
class Settings extends Database{

	private $settings;
	private $table_name;

	public function __construct()
	{
		parent::__construct();

		$this->table_name = DB_PREFIX.'settings';
		$this->select_all_settings();
	}

	/**
	 * Get saved settings from database
	 */
	private function select_all_settings()
	{

		$columns = array();
		$columns['setting_name'] = 'name';
		$columns['setting_value'] = 'value';
		$this->select($columns);

		$this->from($this->table_name);

		$results = $this->all_results();
		$this->settings = array();
		
		foreach ($results as $key => $value) {
			$this->settings[$value->name] = $value->value;
		}
	}

	/**
	 * Get settings
	 * @param string $name get single setting
	 */
	public function get_settings($name = NULL)
	{

		if (isset($name)) {
			// Check if setting avalaible
			if (isset($this->settings[$name])) {
				return $this->settings[$name];
			}else{
				return false;
			}
		}

		return $this->settings;
	}

	/**
	 * Update existing setting or save new setting
	 * 
	 * @param string $name setting name
	 * @param mix value or array of values
	 */
	public function set_setting($name, $value)
	{
		if (is_array($value)) {
			$value = json_encode($value);
		}

		$data = array();
		$data['setting_name'] = $name;
		$data['setting_value'] = $value;

		// Update if aleady exists
		if ($this->get_settings($name)) {
			$this->where('setting_name', $name);
			$this->update($this->table_name, $data);	
		}else{
			$this->insert($this->table_name, $data);
		}

		// Reload all settings
		$this->select_all_settings();
	}

	/**
	 * Delete setting
	 * 
	 * @param string $name setting_name
	 */
	public function delete_setting($name)
	{
		$this->where('setting_name', $name);
		$this->delete($this->table_name);

		// Reload all settings
		$this->select_all_settings();
	}
}