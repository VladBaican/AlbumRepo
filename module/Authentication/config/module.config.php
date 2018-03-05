<?php
namespace Authentication;

use Zend\Router\Http\Literal;

return [
    'service_manager' => [
        'factories' => [
            Model\AuthenticationAdapter::class =>
                Factory\AuthenticationAdapterFactory::class,
            Services\AuthenticationService::class =>
                Factory\AuthenticationServiceFactory::class
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
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ]
];
