<?php
namespace Authentication\Services;

use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use Authentication\Model\AuthenticationAdapter;
use Zend\Authentication\Storage\StorageInterface;
use Zend\InputFilter\InputFilter;

/**
 * Authentication Service
 */
class AuthenticationService extends ZendAuthenticationService
{
    /**
     * @const LOGIN_FAIL
     */
    const LOGIN_FAIL = -1;

    /**
     * @const LOGIN_SUCCES
     */
    const LOGIN_SUCCESS = 1;

    /**
     * @var InputFilter
     */
    protected $inputFilter;

    /**
     * Constructor.
     *
     * @param  StorageInterface $storage
     * @param  AuthenticationAdapter $adapter
     */
    public function __construct(
        StorageInterface $storage = null,
        AuthenticationAdapter $adapter = null
    ) {
        parent::__construct($storage, $adapter);
    }

    /**
     * Get input filler.
     *
     * @return [type] [description]
     */
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'username',
            'required' => true,
        ]);

        $inputFilter->add([
            'name' => 'password',
            'required' => true,
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}
