<?php

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
