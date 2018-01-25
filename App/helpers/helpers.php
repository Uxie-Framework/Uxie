<?php

// include a view
function view(string $view, array $data = [])
{
    if (getenv('TEMPLATING_ENGINE') == 'Blade') {
        bladeView($view, $data);
    } else {
        pugView($view, $data);
    }
}
function bladeView(string $view, array $data = [])
{
    global $container;
    $container->build('Blade', ['../Views', '../cache/blade']);

    echo $container->get('Blade')->make($view, $data);
}

function pugView(string $view, array $data = [])
{
    global $container;
    $container->build('Pug', [[
        'expressionLanguage' => 'php',
        'cache'              => '../cache/pug',
        'basedir'            => '../Views',
        ]]);

    echo $container->get('Pug')->render("../Views/$view.pug", $data);
}

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

function session($key, $value = null)
{
    session_start();
    if (!$value && isset($_SESSION[$key])) {
        return $_SESSION[$key];
    } elseif (!$value) {
        return false;
    }
    $_SESSION[$key] = $value;
}

function unsetSession($key)
{
    session_start();
    unset($_SESSION[$key]);
}

function cookie($key, $value = null, $time = null)
{
    if ($value && $time) {
        setcookie($key, $value, $time);
    } elseif ($value && !$time) {
        setcookie($key, $value);
    } elseif (!$value && !$time) {
        return $_COOKIE[$key];
    } else {
        return false;
    }
}

function unsetCookie($key)
{
    setcookie($key, '', time() - 1);
}

function csrf_field()
{
    $token = uniqid(random_int(0, 1000));
    session('_token', $token);
    echo "<input type='hidden' name='_token' value='".$token."'>";
}
