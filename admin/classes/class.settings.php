<?php
class settings extends database{

	private $settings;

	public function __construct()
	{
		parent::__construct();
		$this->settings = $this->get_all_settings();
	}

	private function get_all_settings()
	{
		# code...
	}

	public function get_settings($key = NULL)
	{
		if (isset($key)) {
			return $this->settings[$key];
		}
	}

	public function set_setting($key, $value)
	{
		# code...
	}
}