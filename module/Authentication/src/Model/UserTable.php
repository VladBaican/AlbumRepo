<?php
namespace Authentication\Model;

use Zend\Db\TableGateway\TableGatewayInterface;

/**
 * User Table
 */
class UserTable
{
    /**
     * @var TableGatewayInterface
     */
    protected $tableGateway;

    /**
     * Constructor.
     *
     * @param TableGatewayInterface $tableGateway
     */
    public function __construct(
        TableGatewayInterface $tableGateway
    ) {
        $this->tableGateway = $tableGateway;
    }

    /**
     * Save user.
     *
     * @param  array $credentials
     * @return [type]              [description]
     */
    public function saveUser($credentials)
    {
        $data = [
            'username' => $credentials['username'],
            'password'  => $credentials['password']
        ];

        $this->tableGateway->insert($data);
    }
}
