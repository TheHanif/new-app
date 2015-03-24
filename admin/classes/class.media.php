<?php
class Media extends Settings{

	private $table_name;
	private $dimentions;
	private $upload_path;

	public function __construct()
	{
		parent::__construct();

		$this->table_name = DB_PREFIX.'objects';

		$this->dimentions = json_decode($this->get_settings('media'));

		$this->upload_path = ABSPATH."contents/uploads/".date('Y/m/d/');

		if (!file_exists($this->upload_path)) {
			mkdir($this->upload_path, 0777, true);
		}
	
	} // end of __construct()

	/**
	 * Scale and resize image
	 * @param  int $ID media id
	 * @param array $data form data
	 * @return boolean
	 */
	public function scale($ID, $data)
	{
		// Get media info
		$media = $this->get_media($ID);
		$media = $media[0];

		$folder = ABSPATH."contents/uploads/".$this->_date('Y/m/d/', $media->date);
		$image = $folder.$media->file;

		$this->backup_original($ID);


		switch($media->type){
			case 'image/jpeg';
				$images_orig = imagecreatefromjpeg($image);
			break;
			case 'image/png';
				$images_orig = imagecreatefrompng($image);
			break;
			case 'image/gif';
				$images_orig = imagecreatefromgif($image);
			break;
		}

		$photoX = ImagesX($images_orig);
		$photoY = ImagesY($images_orig);

		$images_fin = ImageCreateTrueColor($data['width'], $data['height']);

		ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $data['width']+1, $data['height']+1, $photoX, $photoY);
			
			switch($media->type){
				case 'image/jpeg';
					imagejpeg($images_fin,$image);
				break;
				case 'image/png';
					imagepng($images_fin,$image);
				break;
				case 'image/gif';
					imagegif($images_fin,$image);
				break;
			}
		
		ImageDestroy($images_orig);
		ImageDestroy($images_fin);

		// Update all sizes
		if(isset($data['scale_all']))
			$this->create_images($media->file, $folder);

		return true;
	}

	/**
	 * Backup original image if not exist original image
	 * @param  int  $ID     media id
	 * @param  boolean $backup force backup if file not exist. Pars false if just want to know is file exist
	 * @return boolean
	 */
	public function backup_original($ID, $backup = true)
	{
		$media = $this->get_media($ID);

		if($this->row_count() <= 0) 
			return;

		$media = $media[0];

		$folder = ABSPATH."contents/uploads/".$this->_date('Y/m/d/', $media->date);
		$image = $folder.$media->file;

		$backup_image = str_replace('.', '-backup.', $image);
		if(file_exists($backup_image)){
			return true;
		}elseif($backup && copy($image, $backup_image)){
			return true;
		}

	} // end of backup_original()

	/**
	 * Delete media by ID
	 */
	public function delete_media($ID)
	{	
		if ($this->delete_media_files($ID)) {
		
			$this->where('ID', $ID);
			$this->delete($this->table_name,1);

			return $this->row_count();
		}
		
	} // end of delete_media()

	/**
	 * Delete all images, restore from backup_* file
	 * @param  int $ID media id
	 * @return boolean     
	 */
	public function restore_original($ID)
	{
		$media = $this->get_media($ID);
		$media = $media[0];

		$folder = ABSPATH."contents/uploads/".$this->_date('Y/m/d/', $media->date);
		$image = $folder.$media->file;

		if (file_exists(str_replace('.', '-backup.', $image))) {
			
			$this->delete_media_files($ID, false);
			
			rename(str_replace('.', '-backup.', $image), $image);

			$this->create_images($media->file, $folder);

			return true;
		}
	} // end of retore_original()

	/**
	 * Delete media file by ID
	 */
	public function delete_media_files($ID, $delete_backup = true)
	{
		$media = $this->get_media($ID);

		// if media exists in db
		if ($this->row_count() <= 0) {
			return;
		}

		$media = $media[0];

		$file_directory = ABSPATH."contents/uploads/".$this->_date('Y/m/d/', $media->date);

		$file = $file_directory.$media->file;

		// Delete if file exists
		if (file_exists($file)) {
			unlink($file);

			// if image, delete all croped images
			if(strpos($media->type,"image") !== false){
				$files = array();
				$files[] = str_replace('.', '-thumbnail.', $file);
				$files[] = str_replace('.', '-small.', $file);
				$files[] = str_replace('.', '-medium.', $file);
				$files[] = str_replace('.', '-large.', $file);

				if($delete_backup)
				$files[] = str_replace('.', '-backup.', $file);

				foreach ($files as $file) {
					if (file_exists($file)) {
						unlink($file);
					}
				}
			} // end of croped images

			return true;
		}

	} // end of delete_media_files()

	/**
	 * Get media
	 */
	public function get_media($ID = NULL)
	{
		$this->select(array('ID'=>'ID', 'title'=>'title', 'excerpt'=>'caption', 'content'=>'description', 'name'=>'file', 'ts'=>'date', 'mimetype'=>'type'));

		if (isset($ID)) {
			$this->where('ID', $ID);
		}

		$this->from($this->table_name);
		if ($this->row_count() > 0) {
			return $this->all_results();
		}
	} // end get_media

	public function upload_media($media)
	{

		$name = $media["name"]; // Uploaded media's name
		$mimetype = $media["type"]; // Uploaded media's type

		$upload_path = $this->upload_path;

		$name = $this->get_unique_filename($name);

		$status = move_uploaded_file($media["tmp_name"], $upload_path . $name); // Move uploaded media to folder from temp
		
		if (!$status) {
			return $status;
		}

		$media = array();
		$media['name'] = $name;
		$media['mimetype'] = $mimetype;

		$this->save_media($media);

		//check if media is a image type
		if(strpos($mimetype,"image") !== false){
			
			$this->create_images($name, $upload_path);
			
		} // end of strpos
		
		return true;
	} // end of upload_media()


	public function crop($ID, $data)
	{
		$media = $this->get_media($ID);
		$media = $media[0];

		$folder = ABSPATH."contents/uploads/".$this->_date('Y/m/d/', $media->date);
		$image = $folder.$media->file;

		$this->backup_original($ID);

		switch($media->type){
			case 'image/jpeg';
				$images_orig = imagecreatefromjpeg($image);
			break;
			case 'image/png';
				$images_orig = imagecreatefrompng($image);
			break;
			case 'image/gif';
				$images_orig = imagecreatefromgif($image);
			break;
		}

		$width = ImagesX($images_orig);
		$height = ImagesY($images_orig);

		$pw = $data['iw'] / $width *100;
		$ph = $data['ih'] / $height *100;

		$spw = $w = $width/100*($data['w'] / $data['iw'] * 100);
		$sph = $h = $height/100*($data['h'] / $data['ih'] * 100);

		$x = $width/100*($data['x'] / $data['iw'] * 100);
		$y = $height/100*($data['y'] / $data['ih'] * 100);

		// Thumbnail only
		if(isset($data['radio_crop']) && $data['radio_crop'] === 'thumbnail'){
			$image = str_replace('.', '-thumbnail.', $image);
			$w 	= $this->dimentions->thumbnail->w;
			$h  = $this->dimentions->thumbnail->h;
		}

		$images_fin = ImageCreateTrueColor($w, $h);

		ImageCopyResampled($images_fin, $images_orig, 0, 0, $x, $y, $w, $h, $spw, $sph);

			
		switch($media->type){
			case 'image/jpeg';
				imagejpeg($images_fin,$image);
			break;
			case 'image/png';
				imagepng($images_fin,$image);
			break;
			case 'image/gif';
				imagegif($images_fin,$image);
			break;
		}
	
		ImageDestroy($images_orig);
		ImageDestroy($images_fin);


		// Update all sizes
		if(isset($data['radio_crop']) && $data['radio_crop'] === 'except')
			$this->create_images($media->file, $folder, false);
	}// end of crop()

	/**
	 * Flip or rotate image
	 * @param  int $ID   media id
	 * @param  arrat $data action
	 * @return boolean
	 */
	public function flip_rotate($ID, $data)
	{
		$media = $this->get_media($ID);
		$media = $media[0];

		$folder = ABSPATH."contents/uploads/".$this->_date('Y/m/d/', $media->date);
		$image = $folder.$media->file;

		$this->backup_original($ID);

		switch($media->type){
			case 'image/jpeg';
				$images_orig = imagecreatefromjpeg($image);
			break;
			case 'image/png';
				$images_orig = imagecreatefrompng($image);
			break;
			case 'image/gif';
				$images_orig = imagecreatefromgif($image);
			break;
		}

		// Flip Image
		if (isset($data['flip'])) {

			$photoX = $v = ImagesX($images_orig);
			$photoY = $h = ImagesY($images_orig);

			$images_fin = ImageCreateTrueColor($photoX, $photoY);

			if ($data['flip'] === 'v') {
				// Flip Verticle
				ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, $photoY-1, $photoX, $photoY, $photoX, -$photoY);
			}elseif ($data['flip'] === 'h') {
				// Flip Horizontal
				ImageCopyResampled($images_fin, $images_orig, 0, 0, $photoX-1, 0, $photoX, $photoY, -$photoX, $photoY);
			}
		}

		// Rotate Image
		if (isset($data['rotate'])) {
			
			if ($data['rotate'] === 'c') {
				// Rotate clockwise
				$degrees = -90;
			} elseif($data['rotate'] === 'ac') {
				// Rotate anti clockwise
				$degrees = 90;
			}
			
			$images_fin = imagerotate($images_orig, $degrees, 0);
		}

		switch($media->type){
			case 'image/jpeg';
				imagejpeg($images_fin,$image);
			break;
			case 'image/png';
				imagepng($images_fin,$image);
			break;
			case 'image/gif';
				imagegif($images_fin,$image);
			break;
		}

		// Update all sizes
		// if(isset($data['flip_all']))
			$this->create_images($media->file, $folder);

		return true;
	} // end of flip_rotate()

	public function save_media($media = NULL, $meta = NULL, $ID = NULL)
	{
		if (isset($media)) {
			$media['type'] = 'media';
			$this->insert($this->table_name, $media);
		} // end media

		if (isset($meta) && isset($ID)) {
			$data = array();
			$data['title'] = $meta['title'];
			$data['excerpt'] = $meta['caption'];
			$data['content'] = $meta['description'];

			$this->where('ID', $ID);
			$this->update($this->table_name, $data);

			return $this->row_count();
		}

	} // end of save_media

	public function create_images($name, $upload_path = NULL, $thumbnail = true)
	{
		foreach ($this->dimentions as $key => $dimention) {

			if(!$thumbnail && $key == 'thumbnail') continue;

			$width 	= $dimention->w;
			$height  = $dimention->h;

			$image = $upload_path . $name;
			$newimage = $upload_path.str_replace('.', '-'.$key.'.', $name);
			copy($image, $newimage);

			$crop = 0;
			if (isset($dimention->c)) {
				$crop = $dimention->c;
			}

			$this->resize($width, $height, $image, $newimage, $crop);
		}
	} // end of create_image()

	protected function upcount_name_callback($matches) {
        $index = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : '';
        return '-'.$index.''.$ext;
    }

    protected function upcount_name($name) {
        return preg_replace_callback(
            '/(?:(?:-([\d]+))?(\.[^.]+))?$/',
            array($this, 'upcount_name_callback'),
            $name,
            1
        );
    }
    protected function get_user_id() {
        @session_start();
        return session_id();
    }

    protected function get_user_path() {
        if ($this->options['user_dirs']) {
            return $this->get_user_id().'/';
        }
        return '';
    }
    protected function fix_integer_overflow($size) {
        if ($size < 0) {
            $size += 2.0 * (PHP_INT_MAX + 1);
        }
        return $size;
    }
    protected function get_file_size($file_path, $clear_stat_cache = false) {
        if ($clear_stat_cache) {
            if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                clearstatcache(true, $file_path);
            } else {
                clearstatcache();
            }
        }
        return $this->fix_integer_overflow(filesize($file_path));
    }

    protected function get_upload_path($file_name = null, $version = null) {
        $file_name = $file_name ? $file_name : '';
        if (empty($version)) {
            $version_path = '';
        } else {
            $version_dir = @$this->upload_path;
            if ($version_dir) {
                return $this->upload_path.$file_name;
            }
            $version_path = $version.'/';
        }
        return $this->upload_path.$file_name;
    }

    protected function get_unique_filename($name, $content_range = null) {
        while(is_dir($this->get_upload_path($name))) {
            $name = $this->upcount_name($name);
        }
        // Keep an existing filename if this is part of a chunked upload:
        $uploaded_bytes = $this->fix_integer_overflow(intval($content_range[1]));
        while(is_file($this->get_upload_path($name))) {
            if ($uploaded_bytes === $this->get_file_size(
                    $this->get_upload_path($name))) {
                break;
            }
            $name = $this->upcount_name($name);
        }
        return $name;
    }

    protected function trim_file_name($file_path, $name, $size, $type, $error,
            $index, $content_range) {
        // Remove path information and dots around the filename, to prevent uploading
        // into different directories or replacing hidden system files.
        // Also remove control characters and spaces (\x00..\x20) around the filename:
        $name = trim(basename(stripslashes($name)), ".\x00..\x20");
        // Use a timestamp for empty filenames:
        if (!$name) {
            $name = str_replace('.', '-', microtime(true));
        }
        // Add missing file extension for known image types:
        if (strpos($name, '.') === false &&
                preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
            $name .= '.'.$matches[1];
        }
        if (function_exists('exif_imagetype')) {
            switch(exif_imagetype($file_path)){
                case IMAGETYPE_JPEG:
                    $extensions = array('jpg', 'jpeg');
                    break;
                case IMAGETYPE_PNG:
                    $extensions = array('png');
                    break;
                case IMAGETYPE_GIF:
                    $extensions = array('gif');
                    break;
            }
            // Adjust incorrect image file extensions:
            if (!empty($extensions)) {
                $parts = explode('.', $name);
                $extIndex = count($parts) - 1;
                $ext = strtolower(@$parts[$extIndex]);
                if (!in_array($ext, $extensions)) {
                    $parts[$extIndex] = $extensions[0];
                    $name = implode('.', $parts);
                }
            }
        }
        return $name;
    }

    protected function get_file_name($file_path, $name, $size, $type, $error,
            $index, $content_range) {
        return $this->get_unique_filename(
            $file_path,
            $this->trim_file_name($file_path, $name, $size, $type, $error,
                $index, $content_range),
            $size,
            $type,
            $error,
            $index,
            $content_range
        );
    }
	
	public function resize($width, $height, $image, $newimage, $crop = 0){
					
		$size=GetimageSize($image);
		
		// resize image if larger than thumbnail sizes
		if($size[0] > $width || $size[1] > $height){

			$_width = $width;
			$_height = $height;
			$x=0;
			$y=0;

			switch($size['mime']){
				case 'image/jpeg';
					$images_orig = imagecreatefromjpeg($newimage);
				break;
				case 'image/png';
					$images_orig = imagecreatefrompng($newimage);
				break;
				case 'image/gif';
					$images_orig = imagecreatefromgif($newimage);
				break;
			}

			$photoX = ImagesX($images_orig);
			$photoY = ImagesY($images_orig);

			if($crop === 0){
				if($size[0] < $size[1])
					$_width = round($width*$size[0]/$size[1]);
				elseif($size[0] > $size[1])
					$_height = round($height*$size[1]/$size[0]);
			}else{

				if($size[0] > $size[1]){
					$_width = round($width*$size[0]/$size[1]);
					$x = round((($photoX/$width)/2)*($width/2));
				}elseif($size[0] < $size[1]){
					$_height = round($height*$size[1]/$size[0]);
					$y = (round((($photoY/$height)/2)*($height/2)));
				}
			}
			
			if($crop === 0){
				$images_fin = ImageCreateTrueColor($_width, $_height);
			}else{
				$images_fin = ImageCreateTrueColor($width, $height);
			}
			ImageCopyResampled($images_fin, $images_orig, 0, 0, $x, $y, $_width+1, $_height+1, $photoX, $photoY);
			
			switch($size['mime']){
				case 'image/jpeg';
					imagejpeg($images_fin,$newimage);
				break;
				case 'image/png';
					imagepng($images_fin,$newimage);
				break;
				case 'image/gif';
					imagegif($images_fin,$newimage);
				break;
			}
			
			ImageDestroy($images_orig);
			ImageDestroy($images_fin);
		} 
	}// end of resize()
}