<?php
namespace Artist;

return [
    'service_manager' => [
        'factories' => [
            Model\AuthenticationAdapter::class =>
                Factory\AuthenticationAdapterFactory::class,
            Services\AuthenticationService::class =>
                Factory\AuthenticationServiceFactory::class
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ]
];
