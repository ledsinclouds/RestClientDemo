<?php
namespace RestClientDemo\Form;

use Zend\InputFilter\InputFilter;

class AlbumFormFilter extends InputFilter{

	public function __construct(){
		$this->add(array(
			'name' => 'artist',
			'required' => true,
			'filters' => array(
				array('name' => 'stringTrim'),
			)
		));
		$this->add(array(
			'name' => 'title',
			'required' => true,
			'filters' => array(
				array('name' => 'stringTrim'),
			)
		));
	}

}
