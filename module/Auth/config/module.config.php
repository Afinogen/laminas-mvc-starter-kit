<?php
declare(strict_types=1);

namespace Auth;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

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
