<?php
namespace Authentication\Services;

use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use Application\Adapter\AuthenticationAdapter;

/**
 * Authentication Service
 */
class AuthenticationService extends ZendAuthenticationService
{
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
