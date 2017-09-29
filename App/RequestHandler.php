<?php

namespace App;

class RequestHandler
{
    public function __construct()
    {
        if (($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST))) {
            $this->setupRequest();

            return $this;
        }

        return false;
    }

    // set POST values to variables
    private function setupRequest()
    {
        $keys = array_keys($_POST);
        $values = array_values($_POST);
        for ($i = 0; $i < count($_POST); $i++) {
            $this->{$keys[$i]} = $values[$i];
        }
    }
}
