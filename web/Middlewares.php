<?php

namespace Web;

class Middlewares
{
    // Middlewares to be executed before the script
    // Route for first value ,Middleware name for second value
    public $globalMiddlewares = [
        //'globalMiddleware',
    ];
    public static $priorMiddlewares = [
        //'' => 'statistics',
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
