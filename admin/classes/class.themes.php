<?php
class Themes extends Database{


	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get Installed themes
	 */
	public function get_theme_list()
	{	
		// Init list
		$themes = array();

		$path = CONTPATH.'themes/';
		// Read theme dir
		$dir = opendir($path);

		// Loop through dir
		while($theme_name = readdir($dir)){
          if(is_file($theme_name) || substr($theme_name, 0, 1) == '.') continue;

          // Check if proper style sheet exists
          if(!file_exists(CONTPATH.'themes/'.$theme_name.'/styles.css')) continue;

          // Add to list
          $themes[$theme_name] = $this->get_theme_info($theme_name);

          // Get thumbnail
          if (file_exists($path.$theme_name.'/thumbnail.png')) {
          	$themes[$theme_name]['preview'] = CONTURL.'themes/'.$theme_name.'/thumbnail.png';
          }else{
          	$themes[$theme_name]['preview'] = ADMINURL.'assets/images/nopreview.png';
          }
          
        } // end while

        // Return list
        return $themes;
	}

	public function get_theme_info($theme)
	{

		// File path
		$file = CONTPATH.'themes/'.$theme.'/styles.css';

		// Name: Test theme
		// Author: Muhammad Hanif
		// Version: 1.0
		// Description: Test Description of the theme

		// URL: http://google.com

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