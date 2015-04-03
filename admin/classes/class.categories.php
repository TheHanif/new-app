<?php
class Categories extends Database{

	private $table_name;
	public $Media;

	public function __construct()
	{
		parent::__construct();
		$this->table_name = DB_PREFIX.'categories';

		$this->Media = new Media();
	} // end of __construct()

	public function delete_category($category_ID)
	{
		$this->where('category_id', $category_ID);
		$this->from($this->table_name,1);

		if ($this->row_count() == 0) {
			return false;
		}

		$category = $this->result();

		$this->where('category_id', $category_ID);
		$this->delete($this->table_name,1);

		$count = $this->row_count();

		if($count > 0){
			$this->where('category_parent', $category_ID);
			$this->update($this->table_name, array('category_parent'=>$category->category_parent));
		}

		return 1;
	} // end of delete_category()

	/**
	 * Get categories
	 */
	public function get_categories($type, $category_ID = NULL)
	{
		if (isset($category_ID)) {
			$this->where('category_id', $category_ID);
		}

		$this->where('category_type', $type);
		$this->from($this->table_name);

		if ($this->row_count() > 0 && isset($category_ID)) {
			return $this->result();
		}elseif($this->row_count() > 0){
			return $this->all_results();
		}
	} // end of get_categories()

	/**
	 * Save or insert new category
	 */
	public function save_category($data, $type, $category_ID = NULL)
	{	
		// print_f($data, 1);
		extract($data);

		$category_data = array();
		$category_data['category_name'] = $name;
		$category_data['category_slug'] = $this->generate_slug($name, $category_ID);
		$category_data['category_description'] = $description;
		$category_data['category_media'] = $image;
		$category_data['category_parent'] = $parent;
		$category_data['category_order'] = $order;
		$category_data['category_type'] = $type;

		if (isset($category_ID)) {
			// Update old
			$this->where('category_id', $category_ID);
			$this->update($this->table_name, $category_data);
		}else{
			// Insert new
			$this->insert($this->table_name, $category_data);
		}

		return 1;
	} // end of save_category()

	/**
	 * Generate unique slug
	 */
	public function generate_slug($name, $category_ID = NULL)
	{
		$name = str_replace(' ', '-', strtolower($name));

		$this->where('category_slug', $name.'%', 'LIKE');

		if (isset($category_ID)) {
			$this->where('category_id', $category_ID, '!=');
		}

		$this->from($this->table_name);

		if ($this->row_count() > 0) {
			$name .= '-'.($this->row_count()+1);
		}

		return $name;
	}// end of generate_slug()
}