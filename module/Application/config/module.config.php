<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => function ($container) {
                return new Controller\IndexController(
                    $container->get('acl'),
                    $container->get(\Authentication\Services\AuthenticationService::class)
                );
            }
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
            [
                'label' => 'Album',
                'route' => 'album',
                'pages' => [
                    [
                        'label'  => 'Add',
                        'route'  => 'album',
                        'action' => 'add'
                    ],
                    [
                        'label'  => 'Edit',
                        'route'  => 'album',
                        'action' => 'edit'
                    ],
                    [
                        'label'  => 'Delete',
                        'route'  => 'album',
                        'action' => 'delete'
                    ]
                ],
            ],
            [
                'label' => 'Blog',
                'route' => 'blog',
                'pages' => [
                    [
                        'label'  => 'Add',
                        'route'  => 'blog/add',
                        'action' => 'add'
                    ],
                    [
                        'label'  => 'Edit',
                        'route'  => 'blog/edit',
                        'action' => 'edit'
                    ],
                    [
                        'label'  => 'Delete',
                        'route'  => 'blog/delete',
                        'action' => 'delete'
                    ],
                    [
                        'label'  => 'Detail',
                        'route'  => 'blog/detail',
                        'action' => 'detail'
                    ]
                ],
            ],
            [
                'label' => 'Artist',
                'route' => 'artist',
                'pages' => [
                    [
                        'label'  => 'Add',
                        'route'  => 'artist/add',
                        'action' => 'add'
                    ],
                    [
                        'label'  => 'Edit',
                        'route'  => 'artist/edit',
                        'action' => 'edit'
                    ],
                    [
                        'label'  => 'Delete',
                        'route'  => 'artist/delete',
                        'action' => 'delete'
                    ]
                ],
            ],
            // [
            //     'label' => 'Authentication',
            //     'route' => 'authentication',
            // ]
        ],
    ],
    'service_manager' => [
        'factories' => [
            'navigation' => Zend\Navigation\Service\DefaultNavigationFactory::class,
            'album_event_manager' => function ($container) {
                $eventManager = new \Zend\EventManager\EventManager();

                $albumEventListener = new \Album\EventListener\AlbumEventListener(
                    $container->get(\Album\Model\AlbumTable::class),
                    $container->get(\Artist\Service\ArtistService::class)
                );
                $albumEventListener->attach($eventManager);

                return $eventManager;
            },
            'user_event_manager' => function ($container) {
                $eventManager = new \Zend\EventManager\EventManager();

                $userEventListener = new \Authentication\EventListener\UserEventListener(
                    $container->get(\Authentication\Model\UserRoleTable::class)
                );
                $userEventListener->attach($eventManager);

                return $eventManager;
            },
            'translator' => function ($container) {
                $translator = new \Zend\I18n\Translator\Translator();
                $translatorService = new Services\TranslatorService(
                    $translator
                );

                return $translatorService;
            },
            'acl' => function ($container) {
                return new Services\AclService(
                    new \Zend\Permissions\Acl\Acl()
                );
            }
        ],
    ]
];
