<?php
namespace Authentication\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use \Zend\Db\Adapter\Adapter;
use Authentication\Model\AuthenticationAdapter;

/**
 * Authentication Adapter Factory
 */
class AuthenticationAdapterFactory implements FactoryInterface
{
    /**
     * @param  ContainerInterface       $container
     * @param  string                   $requestedName
     * @param  array                    $options
     * @return AuthenticationAdapter
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        return new AuthenticationAdapter(
            $container->get(Adapter::class),
            AuthenticationAdapter::TABLE_NAME,
            AuthenticationAdapter::IDENTITY_COLUMN,
            AuthenticationAdapter::CREDENTIAL_COLUMN,
            null
        );
    }
}
