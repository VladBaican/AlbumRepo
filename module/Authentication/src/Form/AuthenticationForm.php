<?php

namespace Authentication\Form;

use Zend\Form\Form;

/**
 * Authentication Form
 */
class AuthenticationForm extends Form
{
    /**
     * Initialization.
     */
    public function init()
    {
        parent::__construct('authentication');

        $this->add([
            'name' => 'username',
            'type' => 'text'
        ]);

        $this->add([
            'name' => 'password',
            'type' => 'password'
        ]);
    }
}
