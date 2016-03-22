<?php
class Menus extends Database{

	private $table_name;

	public function __construct()
	{
		parent::__construct();
		$this->table_name = DB_PREFIX.'menus';

	} // end of __construct()

	public function get_menu($ID)
	{
		$this->where('ID', $ID);
		$this->from($this->table_name);
		return $this->result();
	} // end of get_menu()

	public function get_menus()
	{
		$this->from($this->table_name);
		return $this->all_results();
	} // end of get_menus()


	public function save_menu($data, $ID = NULL){	
		
		$menu_data = array();
		
		$menu_data['name'] = $data['menu_name'];
		$menu_data['raw'] = '';
		$menu_data['structure'] = '';
		
		if (isset($data['items'])) {
			$menu_data['raw'] = json_encode($data['items']);
			$menu_data['structure'] = json_encode($this->generate_structure($data['items']));
		}

		if (isset($ID)) {
			// Update old
			$this->where('id', $ID);
			$this->update($this->table_name, $menu_data);
		}else{
			// Insert new
			$this->insert($this->table_name, $menu_data);
		}

		return $this->row_count();
	} // end of save_menu()

	public function generate_structure($raw, $parent = 0){

		$structure = array();
    
	    foreach ($raw as $key => $value) {
	        if ($value['parent'] == $parent) {

	        	if (!is_array($structure)) {
	        		$structure = array();
	        	}

	        	$value = $this->get_detailed($value);

	            $value['children'] = $this->generate_structure($raw, $key);
	            $structure[] = $value;
	        }
	    }
	    return $structure;

	} // end of generate_structure()

	public function get_detailed($item){

		return $item;
	} // end of get_detailed()

}