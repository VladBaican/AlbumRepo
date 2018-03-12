<?php
namespace Authentication\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use \Zend\Db\Adapter\AdapterInterface;
use \Zend\Db\TableGateway\TableGateway;
use Authentication\Model\UserRoleTable;

/**
 * User Role Table Factory
 */
class UserRoleTableFactory implements FactoryInterface
{
    /**
     * @param  ContainerInterface       $container
     * @param  string                   $requestedName
     * @param  array                    $options
     * @return UsersRolesTable
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $dbAdapter = $container->get(AdapterInterface::class);
        $userRoleTableGateway =
            new TableGateway('usersRoles', $dbAdapter, null, null);
        return new UserRoleTable(
            $userRoleTableGateway
        );
    }
}
