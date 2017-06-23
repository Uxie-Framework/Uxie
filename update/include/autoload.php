<?php
session_start();
ob_start();
date_default_timezone_set('Africa/Algiers');
error_reporting(-1);

set_exception_handler(function(Exception $e) {
  $Msg = $e->getMessage();
  $Code = $e->getCode();
  new classes\ThrowError($Msg, $Code);
});

spl_autoload_register(function ($className) {
    $className = ltrim($className, '\\');
    $fileName = '';
    if ($lastNsPos = strripos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
    }
    $fileName = __DIR__.DIRECTORY_SEPARATOR.$fileName.$className.'.php';
    if (file_exists($fileName)) {
        require $fileName;
        return true;
    }
    return false;
});
