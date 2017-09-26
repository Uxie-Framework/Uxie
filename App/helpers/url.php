<?php

// return full valide url (inside application)
function fullUrl(string $url)
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
    header('Location: '.$url);
}
// include a view
function view(string $view, array $data = null)
{
    if ($data) {
        $keys = array_keys($data);
        $values = array_values($data);
        for ($i=0; $i < count($keys); $i++) {
            ${$keys[$i]} = $values[$i];
        }
    }
    require_once '../Views/'.$view.'.php';
}
