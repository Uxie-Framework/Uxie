<?php

namespace Filter;

use Validator\Validator as Validator;
use Filter\Filterable as Filterable;
use Request\Request as Request;

class ExampleValidator extends Validator implements Filterable
{
    public function __construct(Request $request)
    {
        parent::__construct();
        $this
        ->setInput('name')
        ->required('Failed message')
        ->length(10, 20, 'length not authorized')
        ->validate();
    }

    public function check(): bool
    {
        if ($this->isValide()) {
            return true;
        }

        return false;
    }
}
