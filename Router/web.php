<?php

namespace Router;

class web
{
    protected $routes = [
        ''      => 'index',
        'error' => 'error',
        'update' => 'update',
    ];

    protected $priorMiddleware = [
        'update' => 'updateMiddleware',
    ];

    protected $lateMiddleware = [

    ];
}
