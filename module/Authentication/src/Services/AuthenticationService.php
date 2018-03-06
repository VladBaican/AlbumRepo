<?php
namespace Authentication\Services;

use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use Authentication\Model\AuthenticationAdapter;
use Zend\Authentication\Storage\StorageInterface;

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
    const LOGIN_SUCCES = 1;

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
}
