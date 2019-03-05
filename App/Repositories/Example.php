<?php
namespace Repository;

use Model\Example as Model;

class Example
{
    private $model;

    public function __construct()
    {
        $this->model = new Model;
    }
}