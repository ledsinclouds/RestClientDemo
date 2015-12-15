<?php
namespace RestClientDemo\Form;

use Zend\InputFilter\InputFilter;

class AlbumFormFilter extends InputFilter{

	public function __construct(){
		$this->add(array(
			'name' => 'song_title',
			'required' => true,
			'filters' => array(
				array('name' => 'stringTrim'),
			)
		));
	}

}
