<?php

session_start();
ob_start();
date_default_timezone_set('Africa/Algiers');
error_reporting(-1); // (not for production)

set_exception_handler(function (Throwable $e) {
    $Msg = $e->getMessage();
    $Code = $e->getCode();
    new App\ThrowError($Msg, $Code); // this should be changed on production
});
