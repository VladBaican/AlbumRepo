<?php
namespace Authentication\Model;

use Zend\Authentication\Validator\Authentication;

/**
 * Authentication Validator
 */
class AuthenticationValidator extends Authentication
{
    /**
     * Sets validator options.
     *
     * @param mixed $options
     */
    public function __construct($options = null)
    {
        parent::__construct($options);
    }
}
