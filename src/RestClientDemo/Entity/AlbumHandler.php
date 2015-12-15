<?php
namespace RestClientDemo\Entity;

class AlbumHandler extends \ArrayObject{

	protected $artist = '';
	protected $title = '';

	public function getId(){
		return $this->id;
	}

	public function setArtist($value){
		$this->artist = $value;
		return $this;
	}

	public function getArtist(){
		return $this->artist;
	}

	public function setTitle($value){
		$this->title = $value;
		return $this;
	}

	public function getTitle(){
		return $this->title;
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
