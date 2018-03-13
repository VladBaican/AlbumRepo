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
     * @const ADMIN_ROLE
     */
    const ADMIN_ROLE = 'admin';

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
        $this
            ->registerRoles()
            ->registerResources()
            ->registerPermissions();
    }

    /**
     * Register the application's roles.
     *
     * @return AclService
     */
    public function registerRoles()
    {
        $this->acl->addRole(new Role(self::GUEST_ROLE));
        $this->acl->addRole(new Role(self::USER_ROLE));
        $this->acl->addRole(new Role(self::ADMIN_ROLE));

        return $this;
    }

    /**
     * Register the application's resources.
     *
     * @return AclService
     */
    public function registerResources()
    {
        $this->acl->addResource(new Resource(''));
        $this->acl->addResource(new Resource('authentication'));
        $this->acl->addResource(new Resource('album'));
        $this->acl->addResource(new Resource('add'), 'album');
        $this->acl->addResource(new Resource('blog'));
        $this->acl->addResource(new Resource('artist'));

        return $this;
    }

    /**
     * Register the application's permisions.
     *
     * @return AclService
     */
    public function registerPermissions()
    {
        $this->acl->allow(self::GUEST_ROLE, 'authentication');
        $this->acl->allow(self::GUEST_ROLE, '');

        $this->acl->allow(self::USER_ROLE, 'album');
        $this->acl->allow(self::USER_ROLE, 'blog');
        $this->acl->allow(self::USER_ROLE, 'artist');
        $this->acl->allow(self::USER_ROLE, '');
        $this->acl->allow(self::USER_ROLE, 'authentication');
        $this->acl->deny(self::USER_ROLE, null, ['add', 'delete', 'edit']);
        $this->acl->allow(self::USER_ROLE, null, 'view');

        $this->acl->allow(self::ADMIN_ROLE);


        return $this;
    }

    /**
     * Check if the current user has access to the resource.
     *
     * @param  string  $request
     * @return boolean
     */
    public function isAllowed($resource, $opt)
    {
        try {
            return $this->acl->isAllowed($this->currentUserRole, $resource, $opt);
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
