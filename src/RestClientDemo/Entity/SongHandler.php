<?php
namespace RestClientDemo\Entity;

class SongHandler extends \ArrayObject{
	
	protected $song_id = '';
	protected $album_id = '';
	protected $title = '';

	//public function getId(){
		//return $this->id;
	//}
	
	public function setSongId($value){
		$this->song_id = $value;
		return $this;
	}

	public function getSongId(){
		return $this->song_id;
	}	

	public function setAlbumId($value){
		$this->album_id = $value;
		return $this;
	}

	public function getAlbumId(){
		return $this->album_id;
	}

	public function setSongTitle($value){
		$this->song_title = $value;
		return $this;
	}

	public function getSongTitle(){
		return $this->song_title;
	}

	public function getJsonData(){
		$var = get_object_vars($this);
		foreach($var as &$value){
			if(is_object($value) && method_exists($value, 'getJsonData')){
				$value = $value->getJsonData();
			}
		}
		return $var;
	}

}
