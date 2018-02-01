<?php

namespace App;

/**
 * Provide Error texts for Request validation
 */
trait ValidationErrors
{
    private $validationErrors = [
        'length'   => '$$ Length must be bettwen $$ and $$',
        'required' => '$$ is Required',
        'email'    => '$$ Must be a valide Email',
        'url'      => '$$ Must be a valide URL',
        'isint' => '$$ Must be of type integer',
        'isfloat' => '$$ Must be of type float',
        'isip' => '$$ Must be a valide IP',
    ];
}
