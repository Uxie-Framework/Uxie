<?php

session_start();
ob_start();
date_default_timezone_set(getenv('TIMEZONE'));
error_reporting(getenv('ERROR_REPORTING'));

set_exception_handler(function (Throwable $e) {
    $Msg = $e->getMessage();
    $Code = $e->getCode();
    new App\ThrowError($Msg, $Code);
});
