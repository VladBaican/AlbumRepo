<?php
namespace Authentication\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\Sql\Insert;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\TableIdentifier;
use Authentication\Model\User;
use \Application\Services\AclService;

/**
 * User Table
 */
class UserTable
{
    /**
     * @var TableGatewayInterface
     */
    protected $userTableGateway;

    /**
     * Constructor.
     *
     * @param TableGatewayInterface $userTableGateway
     */
    public function __construct(TableGatewayInterface $userTableGateway)
    {
        $this->userTableGateway = $userTableGateway;
    }

    /**
     * Save user.
     *
     * @param  User $user
     * @return int
     */
    public function saveUser(User $user)
    {
        $insert = new Insert('users');
        $insert->values([
            'username' => $user->getUsername(),
            'password' => $user->getPassword()
        ]);

        $sql = new Sql($this->userTableGateway->getAdapter());
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        if (! $result instanceof ResultInterface) {
            throw new RuntimeException(
                'Database error occurred during user creation'
            );
        }

        return new User(
            $user->getUsername(),
            $user->getPassword(),
            $result->getGeneratedValue()
        );
    }

    /**
     * Get roles for user.
     *
     * @param  string $username
     * @return mixed
     */
    public function getRoles($username)
    {
        $where = new Where();
        $sql = new Sql($this->userTableGateway->getAdapter());
        $select = $sql->select('users');
        $select
            ->columns(['name' => new Expression('name')])
            ->join(
                'usersRoles',
                'users.id = usersRoles.userId',
                []
            )
            ->join(
                'roles',
                'usersRoles.roleId = roles.id',
                []
            )
            ->where($where->equalTo('username', $username));

        $result = $this->userTableGateway->getAdapter()->query(
            $sql->getSqlStringForSqlObject($select),
            Adapter::QUERY_MODE_EXECUTE
        );

        if (0 === $result->count()) {
            return AclService::GUEST_ROLE;
        }

        return $result->toArray()[0]['name'];
    }
}
