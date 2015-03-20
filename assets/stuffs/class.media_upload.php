<?php 
/**
* MEDIA UPLOAD CLASS
*/
class Media_upload
{
	protected $DB;
	protected $inserted_id;
	
	function __construct()
	{
		$this->DB = new database;
	}

	//start uploading media
	public function upload_media($media)
	{

		$name = $media["name"]; // Uploaded media's name
		$mimetype = $media["type"]; // Uploaded media's type

		$folder = ABSPATH."contents/media/".date( 'Y/m/d/', strtotime($this->DB->time));

		if (!file_exists($folder)) {
			mkdir($folder, 0777, true);
		}
		
		move_uploaded_file($media["tmp_name"], $folder . $name); // Move uploaded media to folder from temp
		
		//inser media info to database
		$this->insert_media($name, $mimetype);
		$this->insert_meta("caption", "", $this->inserted_id);
		$this->insert_meta("description", "", $this->inserted_id);
		
		//check if media is a image type
		if(strpos($mimetype,"image") !== false){
			
			$this->insert_meta("ALT", "", $this->inserted_id);
			$this->insert_meta("thumbnail", "thumbnail_".$name, $this->inserted_id);
			$this->insert_meta("medium", "medium_".$name, $this->inserted_id);
			$this->insert_meta("large", "large_".$name, $this->inserted_id);
			$this->create_images($name, $folder);
			
		} // end of strpos
		
	} // end of upload_media()

	public function create_images($name, $folder = NULL, $thumb = true)
	{
		if($thumb === true){
			/*
			* Create thumbnail image
			*/
			$width 	= $this->get_dimention('thumbnail_width');
			$height  = $this->get_dimention('thumbnail_height');

			$image = $folder . $name;
			$thumbnail = $folder."thumbnail_".$name;
			copy($image, $thumbnail);
		
			$crop = 0;
			if ($this->get_dimention('crop_thumbnail') === 'yes') {
				$crop = 1;
			}

			$this->resize($width, $height, $image, $thumbnail, $crop);
		}
				
		/*
		* Create medium image
		*/
		$width 	= $this->get_dimention('medium_width');
		$height  = $this->get_dimention('medium_height');
		
		$image = $folder . $name;
		$medium = $folder."medium_".$name;
		copy($image, $medium);
		
		$this->resize($width, $height, $image, $medium);
		
		/*
		* Create large image
		*/
		$width 	= $this->get_dimention('large_width');
		$height  = $this->get_dimention('large_height');
		
		$image = $folder . $name;
		$large = $folder."large_".$name;
		copy($image, $large);

		$this->resize($width, $height, $image, $large);
	} // end of create_image()
	
	public function resize($width, $height, $image, $thumbnail, $crop = 0){
					
		$size=GetimageSize($image);
		
		// resize image if larger than thumbnail sizes
		if($size[0] > $width || $size[1] > $height){

			$_width = $width;
			$_height = $height;
			$x=0;
			$y=0;

			switch($size['mime']){
				case 'image/jpeg';
					$images_orig = imagecreatefromjpeg($thumbnail);
				break;
				case 'image/png';
					$images_orig = imagecreatefrompng($thumbnail);
				break;
				case 'image/gif';
					$images_orig = imagecreatefromgif($thumbnail);
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
					imagejpeg($images_fin,$thumbnail);
				break;
				case 'image/png';
					imagepng($images_fin,$thumbnail);
				break;
				case 'image/gif';
					imagegif($images_fin,$thumbnail);
				break;
			}
			
			ImageDestroy($images_orig);
			ImageDestroy($images_fin);
		} 
	}// end of resize()

	public function insert_media($name, $mimetype)
	{
		$t = explode('.', $name);
		$data = array(
		'a'		=> AUTH_ID ,
		'c' 	=> $name ,
		'm'		=> $mimetype ,
		't' 	=> 'media' ,
		'd' 	=> $this->DB->time,
		'e'		=> $t[0]
		);

		$insert   =  $this->DB->query("INSERT INTO ".PREFIX."_objects (author,content,mime_type,type,date,title) VALUES(:a,:c,:m,:t,:d, :e)", $data);

		if($insert > 0 ) {
			$this->inserted_id = $this->DB->pdo->lastInsertId();
		}

	}// end of insert_media()
	
	public function insert_meta($meta, $value, $object)
	{
		
		$data = array(
		'o'  => $object,
		'm' => $meta,
		'v' => $value
		);

		return $this->DB->query("INSERT INTO ".PREFIX."_meta (object_id,metakey,value) VALUES(:o,:m,:v)", $data);


	}// end of insert_meta()
	
	//Get dymention from option table
	public function get_dimention($option)
	{
		$this->DB->bind("option_name",$option);
		return $this->DB->single("SELECT option_value FROM ".PREFIX."_options WHERE option_name = :option_name");

	}
}?>