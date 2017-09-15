<?php
namespace Controllers;

use Router\Router as Router;

class IndexController extends Controller
{
    public function index()
    {
        return Router::getView('index');
    }
}
