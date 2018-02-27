<?php
namespace Artist\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Album\Model\AlbumTable;
use Artist\Model\ArtistRepositoryInterface;
use Artist\Service\ArtistService;

class ArtistServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ArtistService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ArtistService(
            $container->get(AlbumTable::class),
            $container->get(ArtistRepositoryInterface::class)
        );
    }
}
