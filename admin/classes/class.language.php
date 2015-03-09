<?php

class Language extends Settings{

	private $lang_info = array();
	private $lang_data = array();

	/**
	 * Constructor function
	 */
	public function __construct()
	{	
		parent::__construct();

		$language = $this->get_language();
		$this->lang_info = $this->get_language_info($language);
		$this->lang_data = $this->get_language_data($language);

	}

	/**
	 * Get all variables from language file
	 */
	public function get_language_data($language)
	{
		// File path
		$file = ADMINABS.'languages/'.$language.'/language.php';

		// Create array
		$language = array();

		// Load file
		include_once $file;

		// Retuen language data
		return $language;
	}

	/**
	 * Get information of language
	 * @param string $language language name to get info
	 */
	public function get_language_info($language)
	{

		// File path
		$file = ADMINABS.'languages/'.$language.'/language.php';
		
		// Read file
		$source = file_get_contents( $file );

		$tokens = token_get_all( $source );
		$comment = array(
		    T_COMMENT,      // All comments since PHP5
		    T_DOC_COMMENT   // PHPDoc comments      
		);
		
		// Check for comments
		foreach( $tokens as $token ) {
		    if( in_array($token[0], $comment) ){
		    	$info = $token[1];
		    	break;
		    }
		}

		// remove head and tail
		$info = str_replace('/**'.PHP_EOL, '', $info);
		$info = str_replace('*/', '', $info);
		$info = explode(PHP_EOL, $info);
		
		// Get details
		$name = end(explode('* Name: ', $info[0]));
		$country = end(explode('* Country: ', $info[1]));
		$direction = end(explode('* Direction: ', $info[2]));

		// Prepare
		$info = array();
		$info['name'] = $name;
		$info['country'] = $country;
		$info['direction'] = $direction;

		return $info;
	}

	/**
	 * Get current language name
	 */
	public function get_language()
	{
		return $this->get_settings('language');
	}

	public function set_language()
	{
		
	}

	/**
	 * Get Installed languages
	 */
	public function list_languages()
	{	
		// Init list
		$languages = array();

		// Read language dir
		$dir = opendir(ADMINABS.'languages/');

		// Loop through dir
		while($language_name = readdir($dir)){
          if(is_file($language_name) || substr($language_name, 0, 1) == '.') continue;

          // Add to list
          $languages[$language_name] = $this->get_language_info($language_name);
        }

        // Return list
        return $languages;
	}

	public function get_key($key)
	{
		echo $this->lang_data[$key];
	}
} // end of class