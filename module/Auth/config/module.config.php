<?php
declare(strict_types=1);

namespace Auth;

use Laminas\Router\Http\Literal;

return [
    'router'       => [
        'routes' => [
            'user' => [
                'type'          => Literal::class,
                'options'       => [
                    'route'    => '/user',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action'     => 'index',
                        'acl'        => [
                            'roles' => ['user'],
                        ],
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'login'    => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/login',
                            'defaults' => [
                                'controller' => Controller\LoginController::class,
                                'action'     => 'login',
                                'acl'        => [
                                    'roles' => ['guest'],
                                ],
                            ],
                        ],
                    ],
                    'register' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/register',
                            'defaults' => [
                                'controller' => Controller\RegisterController::class,
                                'action'     => 'register',
                                'acl'        => [
                                    'roles' => ['guest'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers'  => [
        'factories' => [
            Controller\LoginController::class    => Controller\LoginControllerFactory::class,
            Controller\RegisterController::class => Controller\RegisterControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__.'/../view',
        ],
    ],
];
