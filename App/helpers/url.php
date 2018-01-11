<?php

use Jenssegers\Blade\Blade;

// return full valide url (inside application)
function url(string $url)
{
    $host = 'http'.(($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://').$_SERVER['HTTP_HOST'].'/';

    return $host.$url;
}
// redirect to a specific url (inside application);
function route(string $url)
{
    $host = 'http'.(($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://').$_SERVER['HTTP_HOST'].'/';
    header('Location: '.$host.$url);
}
// reidrect to an external url
function redirect(string $url)
{
    ob_start();
    header('Location: '.$url);
}
// include a view
function view(string $view, array $data = null)
{
    $blade = new Blade('../Views', '../cache/blade');
    if ($data) {
        echo $blade->make($view, $data);
    } else {
        echo $blade->make($view);
    }
}
