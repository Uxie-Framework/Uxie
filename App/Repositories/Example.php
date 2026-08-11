<?php

declare(strict_types=1);

namespace Repository;

use Model\Example as Model;

class Example
{
    private Model $model;

    public function __construct()
    {
        $this->model = new Model();
    }
}