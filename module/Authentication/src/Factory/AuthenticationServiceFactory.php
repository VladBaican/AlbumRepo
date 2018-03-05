<?php
namespace Authentication\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Authentication\Services\AuthenticationService;
use Authentication\Model\AuthenticationAdapter;

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
        $dadd = $container->get(\Zend\Db\Adapter\Adapter::class);
        return new AuthenticationService(
            $dadd,
            $container->get(AuthenticationAdapter::class)
        );
    }
}
