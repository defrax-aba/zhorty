<?php

namespace Zhorty\Form;

use Zend\Form\Form;

class Trim extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->add(array(
            'name' => 'orig_url',
            'options' => array(
                'label' => 'Original URL:',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'trim_path',
            'options' => array(
                'label' => 'Trim Path:',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'options' => array(
                'label' => 'Trim',
            ),
            'attributes' => array(
                'type' => 'submit'
            ),
        ));
    }
}
