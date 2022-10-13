<?php

namespace Zyrus\Providers;

use Zyrus\Application\Application;

class ServiceProvider
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function register()
    {
    }
}