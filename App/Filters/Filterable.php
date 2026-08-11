<?php

declare(strict_types=1);

namespace Filter;

interface Filterable
{
    public function check(): bool;
}
