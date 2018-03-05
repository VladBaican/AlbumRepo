<?php
namespace Authentication\Services;

use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use Application\Adapter\AuthentificationAdapter;

/**
 * Authentication Service
 */
class AuthenticationService extends ZendAuthenticationService
{
    /**
     * Constructor.
     *
     * @param  StorageInterface $storage
     * @param  AuthentificationAdapter $adapter
     */
    public function __construct(
        StorageInterface $storage = null,
        AuthentificationAdapter $adapter = null
    ) {
        parent::__construct($storage, $adapter);
    }
}
