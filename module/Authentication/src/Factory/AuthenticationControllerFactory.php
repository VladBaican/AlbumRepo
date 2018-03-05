<?php
namespace Authentication\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use \Authentication\Controller\AuthenticationController;
use \Authentication\Model\AuthenticationAdapter;

/**
 * Authentication Service Factory
 */
class AuthenticationControllerFactory implements FactoryInterface
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
        return new AuthenticationController(
            $container->get(AuthenticationAdapter::class)
        );
    }
}
