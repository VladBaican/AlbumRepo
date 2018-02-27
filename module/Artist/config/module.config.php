<?php
namespace Artist;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'service_manager' => [
        'aliases' => [
            Model\ArtistRepositoryInterface::class => Model\ZendDbSqlRepository::class
        ],
        'factories' => [
            Model\ZendDbSqlRepository::class => Factory\ZendDbSqlRepositoryFactory::class,
            Service\ArtistService::class => Factory\ArtistServiceFactory::class
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\ArtistController::class => Factory\ArtistControllerFactory::class
        ]
    ],
    'router' => [
        'routes' => [
            'artist' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/artist',
                    'defaults' => [
                        'controller' => Controller\ArtistController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'add' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'action'     => 'add',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/edit/:id',
                            'defaults' => [
                                'action'     => 'edit',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ]
                    ],
                    'delete' => [
                        'type' => Segment::class,
                        'options' => [
                            'route'    => '/delete/:id',
                            'defaults' => [
                                'action'     => 'delete',
                            ],
                            'constraints' => [
                                'id' => '[1-9]\d*',
                            ],
                        ],
                    ]
                ]
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ]
];
