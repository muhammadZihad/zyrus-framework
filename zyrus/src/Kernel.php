<?php

namespace Zyrus;

use Zyrus\Application\Application;
use Zyrus\Facades\Facade;

class Kernel
{
    public $app;

    protected $singletonClasses = [];

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->setGlobalInstances();

        $this->registerServices();
    }

    protected function setGlobalInstances()
    {
        Facade::setFacadeApplication($this->app);
    }


    public function registerServices()
    {
        $this->registerRouteServices();
    }

    public function registerRouteServices()
    {
        $this->app->bind('router', 'Zyrus\Route\Router');
        require_once $this->app->getBasePath() . DIRECTORY_SEPARATOR . 'route.php';
    }
}