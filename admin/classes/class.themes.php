<?php
class Themes extends Database{


	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get Installed themes
	 */
	public function list_themes()
	{	
		// Init list
		$themes = array();

		// Read theme dir
		$dir = opendir(CONTPATH.'themes/');

		// Loop through dir
		while($theme_name = readdir($dir)){
          if(is_file($theme_name) || substr($theme_name, 0, 1) == '.') continue;

          // Add to list
          $themes[$theme_name] = $this->get_theme_info($theme_name);
        }

        // Return list
        return $themes;
	}

	public function get_theme_info($theme)
	{

		// File path
		$file = CONTPATH.'themes/'.$theme.'/styles.css';

        // We don't need to write to the file, so just open for reading.
        $fp = fopen( $file, 'r' );

        // Pull only the first 8kiB of the file in.
        $file_data = fread( $fp, 8192 );

        // PHP will close file handle, but we are good citizens.
        fclose( $fp );

        // Make sure we catch CR-only line endings.
        $file_data = str_replace( "\r", "\n", $file_data );

        $all_headers = array('Name'=>'Name');

         foreach ( $all_headers as $field => $regex ) {
	        if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] )
	            $all_headers[ $field ] = $match[1];
	        else
	            $all_headers[ $field ] = '';
		    }

		return $all_headers;
	}
} // end of class