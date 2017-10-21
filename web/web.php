<?php

namespace web;

class web
{
    // key for url, value for view
    public static $routes = [
        ''      => 'index',                         // using a view

        // using a controller method
        //'error' => 'ErrorsController@displayError',

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
    public $globalMiddlewares = [
        //'globalMiddleware',
    ];
    public static $priorMiddlewares = [
        '' => 'statistics',
        // 'exampleRoute' => 'exampleMiddlewareFile',
        // how to Assign Multi Middlewares
        // 'exampleRoute' => ['exampleMiddlewareFile',
        //                    'example2MiddlewareFile',
        //                ],
    ];

    // Middlewares to be executed after the script
    public static $lateMiddlewares = [
        //
    ];
}
