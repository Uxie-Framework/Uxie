<?php

namespace Router;

class web
{
    protected $routes = [
        ''       => 'index',
        'error'  => 'error',
        'update' => 'update',
    ];
    // Middlewares to be executed before the script
    protected $priorMiddleware = [
        'update' => 'updateMiddleware',
    ];
    // Middlewares to be executed after the script
    protected $lateMiddleware = [

    ];
}
