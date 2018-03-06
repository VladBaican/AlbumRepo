<?php
namespace Authentication;

use Zend\Router\Http\Literal;

return [
    'service_manager' => [
        'factories' => [
            Model\AuthenticationAdapter::class =>
                Factory\AuthenticationAdapterFactory::class,
            Services\AuthenticationService::class =>
                Factory\AuthenticationServiceFactory::class,
            Model\Session::class =>
                Factory\SessionFactory::class
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthenticationController::class => Factory\AuthenticationControllerFactory::class
        ]
    ],
    'router' => [
        'routes' => [
            'authentication' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/authentication',
                    'defaults' => [
                        'controller' => Controller\AuthenticationController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'login' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/login',
                            'defaults' => [
                                'action'     => 'login',
                            ],
                        ],
                    ],
                    'register' => [
                        'type' => Literal::class,
                        'options' => [
                            'route'    => '/register',
                            'defaults' => [
                                'action'     => 'register',
                            ]
                        ]
                    ],
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
