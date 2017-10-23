<?php

$router->get('', function () {
    echo 'hello';
});


$router->get('index/tt/{$hello}/{$tsdf}', 'controller@method');
$router->get('index/test/{$hello}/{$tsdf}', 'controller@method');
$router->get('index/to}/{$tsdf}', 'controller@method');
