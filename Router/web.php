<?php

namespace Router;

abstract class web
{
    // key for url, value for view
    protected $routes = [
        ''       => 'index',
        'error'  => 'error',
        'update' => 'update',
    ];

    // Middlewares to be executed before the script
    // Route for first value ,Middleware for second value
    protected $priorMiddleware = [
        //'update' => 'updateMiddleware', to update this framework
    ];

    // Middlewares to be executed after the script
    protected $lateMiddleware = [

    ];
}
