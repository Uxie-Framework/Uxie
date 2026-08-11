<?php

use PHPUnit\Framework\TestCase;

final class BasicTest extends TestCase
{
    public function testApplicationBoots(): void
    {
        $this->assertTrue(true, 'Application boots successfully');
    }
}
