<?php
class Plugins extends Database{

	private $table_name;

	public function __construct()
	{
		parent::__construct();

		$this->table_name = DB_PREFIX.'objects';
	}

	
	/**
	 * Get Installed plugins
	 */
	public function get_plugin_list()
	{	
		// Init list
		$plugins = array();

		$path = CONTPATH.'plugins/';
		// Read plugin dir
		$dir = opendir($path);

		// Loop through dir
		while($plugin_name = readdir($dir)){
          if(is_file($plugin_name) || substr($plugin_name, 0, 1) == '.') continue;

          // Check if proper style sheet exists
          if(!file_exists(CONTPATH.'plugins/'.$plugin_name.'/plugin.php')) continue;

          // Add to list
          $plugins[$plugin_name] = $this->get_plugin_info($plugin_name);

          
        } // end while

        // Return list
        return $plugins;
	}

	public function get_plugin_info($plugin)
	{

		// File path
		$file = CONTPATH.'plugins/'.$plugin.'/plugin.php';

		$all_headers = array(
			'name'=>'Name'
			,'author'=>'Author'
			,'version'=>'Version'
			,'description'=>'Description'
			,'URL'=>'URL'
			);
		return get_file_header($file, $all_headers);

	}

	public function get_active_plugins($plugin = NULL){

		$plugins = array();

		$this->where('type', 'plugin');

		if (isset($plugin)) {
			$this->where('name', $plugin);
		}else{
			$this->where('status', 'on');
		}

		$this->from($this->table_name);

		if ($this->row_count() > 0) {
			$ps = $this->all_results();
			foreach ($ps as $p) {

				if (!file_exists(CONTPATH.'plugins/'.$p->name.'/plugin.php')) {
					$this->where('name', $p->name);
					$this->delete($this->table_name);
					continue;	
				}

				$plugins[] = $p->name;
			}
		}

		return $plugins;
	}

	public function set_plugin($plugin, $status)
	{
		$this->get_active_plugins($plugin);

		$data = array();
		$data['name'] = $plugin;
		$data['status'] = $status;
		$data['type'] = 'plugin';

		if ($this->row_count() > 0) {
			$this->where('name', $plugin);
			$this->update($this->table_name, $data);	
		}else{
			$this->insert($this->table_name, $data);
		}
	}
} // end of class