<?php
namespace Authentication\Model;

use Zend\Db\TableGateway\TableGatewayInterface;
use Authentication\Model\User;

/**
 * User Role Table
 */
class UserRoleTable
{
    /**
     * @var TableGatewayInterface
     */
    protected $userRoleTableGateway;

    /**
     * Constructor.
     *
     * @param TableGatewayInterface $userRoleTableGateway
     */
    public function __construct(TableGatewayInterface $userRoleTableGateway)
    {
        $this->userRoleTableGateway = $userRoleTableGateway;
    }

    /**
     * Save roles for user.
     *
     * @param  User $user
     */
    public function saveUserRoles(User $user)
    {
        $this->userRoleTableGateway->insert([
            'userId' => $user->getId(),
            'roleId' => 1
        ]);
    }
}
