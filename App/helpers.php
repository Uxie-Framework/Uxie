<?php

// return full valide url (inside application)
function fullUrl(string $url)
{
    $host = 'http'.(($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://').$_SERVER['HTTP_HOST'].'/';
    return $host.$url;
}
// redirect to a specific url (only inside application);
function route(string $url)
{
    $host = 'http'.(($_SERVER['SERVER_PORT'] == 443) ? 's://' : '://').$_SERVER['HTTP_HOST'].'/';
    header('Location: '.$host.$url);
}
// reidrect to an external url
function redirect(string $url)
{
    header('Location: '.$url);
}
// include a view
function view(string $view, array $data = null)
{
    require_once '../Views/'.$view.'.php';
}
//return data stored in url.
function getData()
{
    global $router;
    return $router->data;
}
//retur url with data
function getCurrentUrl()
{
    global $router;
    return $router->getCurrentUrl();
}
