<?php

namespace Zyrus;

use Zyrus\Application\Application;

class Kernel
{
    private $app;

    protected $singletonClasses = [];

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->registerServices();
    }


    public function registerServices()
    {
    }
}