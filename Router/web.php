<?php

namespace Router;

abstract class web
{
    // key for url, value for view
    protected $routes = [
        ''      => 'index',                         // using a view
        'error' => 'ErrorsController@displayError', // using a controller method
        // an example of how to use complex routes
        // 'user'  => [
        //      'profile' => 'profile/show',
        //      'new' => [
        //         'store' => 'UserController@store',
        //      ],
        //  ],
    ];

    // Middlewares to be executed before the script
    // Route for first value ,Middleware name for second value
    public $priorMiddleware = [
        // 'exampleRoute' => 'exampleMiddlewareFile',
        // how to Assign Multi Middlewares
        // 'exampleRoute' => ['exampleMiddlewareFile',
        //                    'example2MiddlewareFile',
        //                ],
    ];

    // Middlewares to be executed after the script
    public $lateMiddleware = [

    ];
}
