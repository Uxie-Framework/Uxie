<?php

namespace Router;

abstract class web
{
    // key for url, value for view
    protected $routes = [
        ''       => 'IndexController@index',
        'error'  => 'ErrorsController@displayError',
    ];

    // Middlewares to be executed before the script
    // Route for first value ,Middleware name for second value
    protected $priorMiddleware = [
        // 'exampleRoute' => 'exampleMiddlewareFile',
        // how to Assign Multi Middlewares
        // 'exampleRoute' => ['exampleMiddlewareFile',
        //                    'example2MiddlewareFile',
        //                ],
    ];

    // Middlewares to be executed after the script
    protected $lateMiddleware = [

    ];
}
