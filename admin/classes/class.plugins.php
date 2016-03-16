<?php
class Plugins extends Database{


	public function __construct()
	{
		parent::__construct();
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
} // end of class