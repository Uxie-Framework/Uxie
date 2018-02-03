<?php

$this->get('', function () {
    view('test');
});

$this->post('test', 'controller@test')->middleware('statistics');

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
