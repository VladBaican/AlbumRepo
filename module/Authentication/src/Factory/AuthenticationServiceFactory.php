<?php
namespace Authentication\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Authentication\Services\AuthenticationService;
use Authentication\Model\AuthenticationAdapter;
use Authentication\Model\Session;
use Authentication\Model\UserTable;
use Authentication\Model\UserRoleTable;

/**
 * Authentication Service Factory
 */
class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * @param  ContainerInterface       $container
     * @param  string                   $requestedName
     * @param  array                    $options
     * @return AuthenticationService
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        return new AuthenticationService(
            $container->get(Session::class),
            $container->get(AuthenticationAdapter::class),
            $container->get(UserTable::class),
            $container->get('user_event_manager')
        );
    }
}
