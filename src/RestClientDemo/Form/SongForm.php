<?php
namespace RestClientDemo\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class SongForm extends Form {

	public function __construct($name = null){

		parent::__construct('song');
		$this->setAttribute('method', 'post');

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
    		'name' => 'album_id'
        ));
        
        //$this->add(array(
            //'type' => 'Zend\Form\Element\Hidden',
    		//'name' => 'song_id'
        //));        

		$this->add(array(
			'name' => 'song_title',
			'type' => 'Zend\Form\Element\Text',
			'attributes' => array(
				'class' => 'form-control',
				'placeholder' => 'Song Title',
				'required' => 'required',
			),
			'options' => array(
				'label' => 'Song Title',
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
