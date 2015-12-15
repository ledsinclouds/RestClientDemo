<?php
namespace RestClientDemo\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class AlbumForm extends Form {

	public function __construct($name = null){

		parent::__construct('album');
		$this->setAttribute('method', 'post');
		
        //$this->add(array(
            //'type' => 'Zend\Form\Element\Hidden',
    		//'name' => 'album_id'
        //));		

		$this->add(array(
			'name' => 'artist',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'form-control',
				'placeholder' => 'Artist Name',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Artist Name',
			)
		));

		$this->add(array(
			'name' => 'title',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'form-control',
				'placeholder' => 'RestClientDemo Title',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'RestClientDemo Title',
			)
		));

		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'class' => 'btn btn-primary',
				'type'  => 'submit',
				'value' => 'submit',
				'id' => 'submitLogin',
			)
		));
	}

}
