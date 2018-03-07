<?php
namespace Authentication\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use \Zend\Db\Adapter\AdapterInterface;
use \Zend\Db\TableGateway\TableGateway;
use Authentication\Model\UserTable;

/**
 * User Table Factory
 */
class UserTableFactory implements FactoryInterface
{
    /**
     * @param  ContainerInterface       $container
     * @param  string                   $requestedName
     * @param  array                    $options
     * @return TableGateway
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $dbAdapter = $container->get(AdapterInterface::class);
        $tableGateway = new TableGateway('users', $dbAdapter, null, null);
        return new UserTable($tableGateway);
    }
}
