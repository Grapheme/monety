<?php

class ImageController extends \BaseController {
	
	var $acceptedTypes = array();
	var $defaultImages = array();
	
	public function __construct(){
		
		parent::__construct();
		
		$this->defaultImages = array(
			'defaul' => getcwd().'/img/no-photo.jpg',
			'avatar-female' => getcwd().'/img/avatars/female.png',
			'avatar-male'=> getcwd().'/img/avatars/male.png',
			'avatar-female-thumbnail' => getcwd().'/img/avatars/female.png',
			'avatar-male-thumbnail' => getcwd().'/img/avatars/male.png'
		);
		
		$this->acceptedTypes = array(
			'text/plain' => asset('img/icons/txt.png'),'application/pdf' => asset('img/icons/pdf.png'),'application/zip' => asset('img/icons/zip.png'),
			'application/x-zip-compressed' => asset('img/icons/zip.png'),'application/msword' => asset('img/icons/word.png'),
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => asset('img/icons/word.png'),
			'application/vnd.ms-excel' => asset('img/icons/excel.png'),'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => asset('img/icons/excel.png'),
			'application/vnd.ms-powerpoint' => asset('img/icons/powerpoint.png'),'application/vnd.openxmlformats-officedocument.presentationml.presentation' => asset('img/icons/powerpoint.png'),
			'audio/mp3' => asset('img/icons/sound.png'),'audio/mpeg' => asset('img/icons/sound.png'),'audio/ogg'=> asset('img/icons/sound.png'),
			'audio/webm'=> asset('img/icons/sound.png'),'audio/aac'=> asset('img/icons/sound.png'),'audio/mp4'=> asset('img/icons/sound.png'),
			'audio/wav'=> asset('img/icons/sound.png'),'audio/x-wav'=> asset('img/icons/sound.png')
		);
	}
	
	public function showImage($image_group,$id){
		
		$image = ''; $filePath = NULL;
		switch($image_group):
			case 'avatar-female':$filePath = User::find($id)->avatar; break;
			case 'avatar-female-thumbnail':$filePath = User::find($id)->thumbnail; break;
			case 'avatar-male':$filePath = User::find($id)->avatar; break;
			case 'avatar-male-thumbnail':$filePath = User::find($id)->thumbnail; break;
		endswitch;
		if(!is_null($filePath) && File::exists(getcwd().'/'.$filePath)):
			$filePath = getcwd().'/'.$filePath;
			$image = File::get($filePath);
		endif;
		if(empty($image)):
			if(isset($this->defaultImages[$image_group])):
				$image = File::get($this->defaultImages[$image_group]);
				$filePath = $this->defaultImages[$image_group];
			else:
				$image = File::get($this->defaultImages['defaul']);
				$filePath = $this->defaultImages['defaul'];
			endif;
		endif;
		$MimeType = 'image/png';
		if(File::exists($filePath)):
			$MimeType = ImageManipulation::open($filePath)->mime;
		endif;
		header('Content-type: '.$MimeType);
		echo $image;
	}

}