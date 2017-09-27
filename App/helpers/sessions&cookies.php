<?php

function session($key, $value = null)
{
    session_start();
    if (!$value) {
        return $_SESSION[$key];
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
    if ($time) {
        setcookie($key, $value, $time);
    } elseif (!$time) {
        setcookie($key, $value);
    } elseif ($value && $time) {
        return $_COOKIE[$key];
    }
}