<?php
namespace Artist\Factory;

use Artist\Form\ArtistForm;
use Artist\Controller\ArtistController;
use Artist\Model\ArtistRepositoryInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ArtistControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ArtistController
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $formManager = $container->get('FormElementManager');
        return new ArtistController(
            $formManager->get(ArtistForm::class),
            $container->get(ArtistRepositoryInterface::class),
            $container->get('album_event_manager')
        );
    }
}
