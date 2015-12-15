<?php
namespace RestClientDemo\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class SongFormValidator implements InputFilterAwareInterface {

    protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {

        if (!$this->inputFilter) {

            $inputFilter = new InputFilter();
            $factory = new InputFactory();


        $inputFilter->add($factory->createInput([
            'name' => 'song_title',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array (
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => '1',
                        'max' => '100',
                    ),
                ),
            ),
        ]));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
