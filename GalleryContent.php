<?php
class GalleryContent {
	public $path; //ścieżka do folderu galerii
	public $thumb_path; //ścieżka do miniaturek(thumbs)
	public function __construct(){
		$this->path = __DIR__ . '/photos';
		$this->thumb_path  = __DIR__ . '/photos/thumbs';
	}
	public function setPath($path, $thumb_path){
		if(substr($path, -1) === '/'){
			$path = substr($path, 0, -1);
		}
		$this->path = $path;
		if(substr($thumb_path, -1) === '/'){
			$thumb_path = substr($thumb_path, 0, -1);
		}
		$this->thumb_path = $thumb_path;
	}
	private function getDirectory($path){
		return scandir($path);
	}
	public function getPhotos(){
		$photos = $this->getDirectory($this->path);
		$extensions = array('jpeg','jpg','png','gif');
		foreach ($photos as $index => $photo) { // ladowanie do tablicy scieżek zdjęć
				$extension = strtolower(end(explode('.', $photo)));
				if(!in_array($extension, $extensions)){
					unset($photos[$index]);
				} else {
					$photos[$index] = array('photo' => $photo);
				}
			}
			if(count($photos))
			return $photos;
			else return false;	
	}
	
}

?>