<?php

ob_start();
date_default_timezone_set(getenv('TIMEZONE'));
error_reporting(getenv('ERROR_REPORTING'));
ini_set('memory_limit', getenv('MEMORY_LIMIT'));

set_exception_handler(function (Throwable $e) {
    container()->ErrorHandler->handle($e);
});
