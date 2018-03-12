<?php
namespace Authentication\Model;

use Zend\Db\TableGateway\TableGatewayInterface;

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

    public function saveUserRoles($data)
    {
        $this->userRoleTableGateway->insert($data);
    }
}
