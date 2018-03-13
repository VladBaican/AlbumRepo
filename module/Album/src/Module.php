<?php
namespace Album;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\AlbumTable::class => function ($container) {
                    $tableGateway = $container->get(Model\AlbumTableGateway::class);
                    $artistRepository = $container->get(Model\ZendDbSqlRepository::class);
                    return new Model\AlbumTable(
                        $tableGateway,
                        $artistRepository
                    );
                },
                Model\AlbumTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
                Model\ZendDbSqlRepository::class => \Artist\Factory\ZendDbSqlRepositoryFactory::class
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AlbumController::class => function ($container) {
                    $controller = new Controller\AlbumController(
                        $container->get(Model\AlbumTable::class),
                        $container->get('album_event_manager'),
                        $container->get('translator')
                    );
                    return $controller;
                },
            ],
        ];
    }
}
