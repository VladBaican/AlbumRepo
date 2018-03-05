<?php
namespace Authentication\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Services\AuthenticationService;
use Model\AuthenticationAdapter;

/**
 * Authentication Service Factory
 */
class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * @param  ContainerInterface       $container
     * @param  string                   $requestedName
     * @param  array                    $options
     * @return AuthentificationService
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        return new AuthenticationService(
            $container->get(\Zend\Db\Adapter\Adapter::class),
            $container->get(AuthenticationAdapter::class)
        );
    }
}
