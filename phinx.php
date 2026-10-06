<?php

declare(strict_types=1);

// load our environment files - used to store credentials & configuration
$dotENV = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotENV->load();

return [
    'paths' => [
        'migrations' => 'database/migrations',
    ],
    'templates' => [
        'file' => 'database/migrations/template.txt',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'production' => [
            'adapter'   => (string) (getenv('DB_CNX') ?: 'mysql'),
            'host'      => (string) (getenv('DB_HOST') ?: '127.0.0.1'),
            'name'      => (string) (getenv('DB_NAME') ?: ''),
            'user'      => (string) (getenv('DB_USER') ?: ''),
            'pass'      => (string) (getenv('DB_PASS') ?: ''),
            'port'      => (string) (getenv('DB_PORT') ?: '3306'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
];
