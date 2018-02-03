<?php

namespace Kernel;

interface KernelInterface
{
    public function prepare();
    public function start();
    public function stop();
}
