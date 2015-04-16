<?php
class Post extends Database{

	private $table_name;
	private $table_meta_name;
	private $user;
	private $categories;

	public function __construct()
	{
		parent::__construct();

		$this->table_name = DB_PREFIX.'objects';
		$this->table_meta_name = DB_PREFIX.'meta';

		$this->user = new Users();
		$this->categories = new Categories();
	}

	/**
	 * Get All posts by type
	 */
	public function get_posts($type)
	{
		$this->where('type', $type);
		$this->from($this->table_name);
		return $this->all_results();
	}

	/**
	 * Get single post
	 */
	public function get_post($post_ID)
	{
		$this->where('ID', $post_ID);
		$this->from($this->table_name);
		return $this->result();
	}// end of get_post()


	/**
	 * Save post
	 */
	public function save_post($data, $post_ID = NULL, $type = NULL)
	{
		if (isset($data['duplicate'])) {
			$post_ID = NULL;
			unset($data['duplicate']);
		}

		// Remove garbej
		if (isset($data['_wysihtml5_mode'])) {
			unset($data['_wysihtml5_mode']);
		}

		$post_data = array();

		// Current logged in user
		$post_data['author'] = $this->user->get_logged_id();

		// Post title
		$post_data['title'] = $data['title'];
		unset($data['title']); // remove from array

		// Post contents
		if(isset($data['content'])){
			$post_data['content'] = $data['content'];
			unset($data['content']);
		}
		
		// Post excerpt
		if(isset($data['excerpt'])){
			$post_data['excerpt'] = $data['excerpt'];
			unset($data['excerpt']);
		}

		// Post slug
		$slug = (isset($data['slug']))? $data['slug'] : NULL;
		$post_data['name'] = $this->get_slug($post_data['title'], $post_ID, $slug);

		// Post parent
		if(isset($data['parent'])){
			$post_data['parent'] = $data['parent'];
			unset($data['parent']);
		}

		// Default status to publish
		$post_data['status'] = 'published';

		// Post type
		$post_data['type'] = $type;

		if (isset($post_ID)) {
			// Update old
			$this->where('ID', $post_ID);
			$this->update($this->table_name, $post_data);

			// delete categories if deselected all
			if (!isset($data['categories'])) {
				$this->delete_meta($post_ID, 'category');
			}

		}else{
			// Insert new
			$this->insert($this->table_name, $post_data);
			$post_ID = $this->last_id();
		}

		// Update categorie post count to negative
		$categories = $this->get_meta($post_ID, 'category');
		if ($categories) {
			foreach ($categories as $category) {
				$this->categories->update_category_count($category->meta_value, -1);
			}
		}

		// delete categories if deselected all
		$this->delete_meta($post_ID, 'category');

		// Insert post categories
		if (isset($data['categories'])) {
			foreach ($data['categories'] as $category) {
				$meta = array();
				$meta['meta_key'] = 'category';
				$meta['meta_value'] = $category;
				$meta['object_id'] = $post_ID;

				$this->insert($this->table_meta_name, $meta);

				// Update categorie post count to positive
				$this->categories->update_category_count($category);
			}
			// Remove from array
			unset($data['categories']);
		} // end of category insert
		
		// Inset other fields as meta
		foreach ($data as $key => $value) {
			$this->save_meta($key, $value, $post_ID);
		}

		return $post_ID;
	} // end of save_post()

	/**
	 * Get unique post slug
	 */
	public function get_slug($title, $post_ID = NULL, $slug = NULL)
	{
		$name = str_replace(' ', '-', $title);

		if (isset($slug) && $name != $slug) {
			$name = preg_replace('/ | \//', '-', $slug);
		}

		$name = strtolower($name);

		$this->where('name', $name.'%', 'LIKE');

		if (isset($post_ID)) {
			$this->where('ID', $post_ID, '!=');
		}

		$this->from($this->table_name);

		if ($this->row_count() > 0) {
			$name .= '-'.($this->row_count()+1);
		}

		return $name;
	} // end of get_slug()

	/**
	 * Save post meta
	 */
	public function save_meta($key, $value, $post_ID){

		$meta = array();
		$meta['meta_key'] = $key;
		$meta['meta_value'] = (is_array($value))? json_encode($value) : $value;
		$meta['object_id'] = $post_ID;

		if ($this->get_meta($post_ID, $key)) {
			$this->where('object_id', $post_ID);
			$this->where('meta_key', $key);
			$this->update($this->table_meta_name, $meta);
		}else{
			$this->insert($this->table_meta_name, $meta);
		}
	} // end of save_meta()

	/**
	 * Get post meta
	 */
	public function get_meta($post_ID, $key = NULL, $single = false)
	{
		$this->where('object_id', $post_ID);
		
		if(isset($key))
		$this->where('meta_key', $key);

		$this->from($this->table_meta_name);

		if ($this->row_count() <= 0) {
			return false;
		}

		// if (isset($key)) {
		// 	$result = $this->result();
		// 	return $result->meta_value;
		// }
		if ($single) {
			$result = $this->result();
			return $result->meta_value;
		}

		return $this->all_results();
	} // end of get_meta()

	/**
	 * Delete post meta
	 */
	public function delete_meta($post_ID, $key = NULL)
	{
		if (isset($key)) {
			$this->where('meta_key', $key);
		}
		$this->where('object_id', $post_ID);
		$this->delete($this->table_meta_name);
	}// end of delete_meta()

}