<?php

/**
 * Define Middlewares Locations
 * This middlewares short names are the ones that should be used
 * When calling a middleware on a route
 *
 */

return [
    'statistics' => \Middleware\Statistics::class,
    'csrf'       => \Middleware\Csrf::class,
];
