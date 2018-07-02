<?php

// load our environment files - used to store credentials & configuration
(new Dotenv\Dotenv('./'))->load();

return
    [
        'paths' => [
            'migrations' => 'database/migrations',
        ],
        'templates' => [
            'file' => 'database/migrations/template.txt'
        ],
        'environments' =>
            [
                'default_migration_table' => 'phinxlog',
                'production' =>
                    [
                        'adapter'   => getenv('DB_CNX'),
                        'host'      => getenv('DB_HOST'),
                        'name'      => getenv('DB_NAME'),
                        'user'      => getenv('DB_USER'),
                        'pass'      => getenv('DB_PASS'),
                        'port'      => 3306,
                        'charset'   => 'utf8',
                        'collation' => 'utf8_unicode_ci',
                    ],
            ],
    ];
