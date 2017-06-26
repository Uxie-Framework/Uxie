<?php

namespace Router;

class web
{
    protected $routes = [
        ''      => 'index',
        'error' => 'error',
    ];

    protected $priorMiddleware = [
        '' => 'MainMiddleware',
    ];

    protected $lateMiddleware = [

    ];
}
