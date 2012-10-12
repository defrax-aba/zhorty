<?php

namespace Zhorty\Form;

use Zend\InputFilter\InputFilter;

class TrimFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name'       => 'orig_url',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'uri',
                    'options' => array('allowRelative' => false)
                ),
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 6,
                        'max' => 255,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        ));

        $this->add(array(
            'name'       => 'trim_path',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'Regex',
                    'options' => array('pattern' => '/^[a-z0-9\-\_]+$/'),
                ),
                array(
                    'name'    => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 30,
                    ),
                ),
            ),
            'filters'   => array(
                array('name' => 'StringTrim')
            ),
        ));
    }
}
