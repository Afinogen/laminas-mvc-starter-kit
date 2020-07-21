<?php

/**
 * Global Configuration Override
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'db' => [
        'adapters' => [
            'mysql' => [
                'driver'   => 'Pdo',
                'dsn'      => 'mysql:dbname=task-manager;host=mysql;charset=utf8',
                'username' => 'root',
                'password' => '12345',
            ],
        ],
    ],
    'session_containers' => [
        Laminas\Session\Container::class,
    ],
    'session_storage' => [
        'type' => Laminas\Session\Storage\SessionArrayStorage::class,
    ],
    'session_config'  => [
        'gc_maxlifetime' => 7200,
        // …
    ],
];
