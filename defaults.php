<?php

declare(strict_types=1);

ob_start();
date_default_timezone_set((string) (getenv('TIMEZONE') ?: 'UTC'));
error_reporting((int) (getenv('ERROR_REPORTING') ?: -1));
ini_set('memory_limit', (string) (getenv('MEMORY_LIMIT') ?: '128M'));

set_exception_handler(function (Throwable $e): void {
    container()->ErrorHandler->handle($e);
});
