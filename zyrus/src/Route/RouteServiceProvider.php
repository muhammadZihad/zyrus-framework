<?php

namespace Zyrus\Route;

use Zyrus\Providers\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('router', 'Zyrus\Route\Router', true);
    }
}