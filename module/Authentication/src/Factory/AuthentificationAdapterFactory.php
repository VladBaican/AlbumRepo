<?php
namespace Authentication\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Model\AuthentificationAdapter;

/**
 * Authentication Adapter Factory
 */
class AuthentificationAdapterFactory implements FactoryInterface
{
    /**
     * @param  ContainerInterface       $container
     * @param  string                   $requestedName
     * @param  array                    $options
     * @return AuthentificationAdapter
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        return new AuthentificationAdapter(
            $container->get(\Zend\Db\Adapter\Adapter::class),
            AuthentificationAdapter::TABLE_NAME,
            AuthentificationAdapter::IDENTITY_COLUMN,
            AuthentificationAdapter::CREDENTIAL_COLUMN,
            null
        );
    }
}
