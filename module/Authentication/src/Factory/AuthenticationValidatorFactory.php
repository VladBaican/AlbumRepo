<?php
namespace Authentication\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Authentication\Model\AuthenticationValidator;
use Authentication\Model\AuthenticationAdapter;
use Authentication\Services\AuthenticationService;

/**
 * Authentication Validator Factory
 */
class AuthenticationValidatorFactory implements FactoryInterface
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
        return new AuthenticationValidator([
            'adapter' => $container->get(AuthenticationAdapter::class),
            'identity' => AuthenticationAdapter::IDENTITY_COLUMN,
            'credential' => AuthenticationAdapter::CREDENTIAL_COLUMN,
            'service' => $container->get(AuthenticationService::class)
        ]);
    }
}
