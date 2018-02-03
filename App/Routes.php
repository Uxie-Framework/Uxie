<?php

$this->get('', function () {
    view('index');
});

// post example
// $this->post('test', 'controller@test');

// resource example
// $this->resource('user', 'controller');

// group example
//$this->group('myprefix/', function () {
//     $this->get('create', function () {
//         view('create');
//     });
// });
