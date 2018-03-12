<?php

namespace Application\Services;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\Permissions\Acl\Exception\InvalidArgumentException;

/**
 * Acl Service
 */
class AclService
{
    /**
     * @const GUEST_ROLE
     */
    const GUEST_ROLE = 'guest';

    /**
     * @const USER_ROLE
     */
    const USER_ROLE = 'user';

    /**
     * @var string
     */
    protected $currentUserRole = self::GUEST_ROLE;

    /**
     * @var Acl
     */
    protected $acl;

    /**
     * Constructor.
     *
     * @param Acl $acl
     */
    public function __construct(Acl $acl)
    {
        $this->acl = $acl;
        $this->registerRoles();
        $this->registerResources();
    }

    /**
     * Register the application roles;
     */
    public function registerRoles()
    {
        $this->acl->addRole(new Role(self::GUEST_ROLE));
        $this->acl->addRole(new Role(self::USER_ROLE));
    }

    /**
     * Register the application resources;
     */
    public function registerResources()
    {
        $this->acl->addResource(new Resource(''));
        $this->acl->addResource(new Resource('authentication'));
        $this->acl->addResource(new Resource('album'));
        $this->acl->addResource(new Resource('blog'));
        $this->acl->addResource(new Resource('artist'));

        $this->acl->allow(self::GUEST_ROLE, 'authentication');
        $this->acl->allow(self::GUEST_ROLE, '');
        $this->acl->deny(self::GUEST_ROLE, 'album');
        $this->acl->deny(self::GUEST_ROLE, 'blog');
        $this->acl->deny(self::GUEST_ROLE, 'artist');

        $this->acl->allow(self::USER_ROLE, 'album');
        $this->acl->allow(self::USER_ROLE, 'blog');
        $this->acl->allow(self::USER_ROLE, 'artist');
        $this->acl->allow(self::USER_ROLE, '');
        $this->acl->allow(self::USER_ROLE, 'authentication');
    }

    /**
     * Check if the current user has access to the request.
     *
     * @param  string  $request
     * @return boolean
     */
    public function isAllowed($request)
    {
        try {
            return $this->acl->isAllowed($this->currentUserRole, $request);
        } catch (InvalidArgumentException $exc) {
            return false;
        }
    }

    /**
     * Set current user role.
     *
     * @param string $role
     */
    public function setUserRoles($roles)
    {
        $this->currentUserRole = $roles;
    }

    /**
     * Get current user role.
     *
     * @return string
     */
    public function getUserRole()
    {
        return $this->currentUserRole;
    }
}
