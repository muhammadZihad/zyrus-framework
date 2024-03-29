<?php

namespace Zyrus;

use Zyrus\Application\Application;
use Zyrus\Exceptions\NotFoundException;
use Zyrus\Facades\Facade;
use Zyrus\Request\Request;
use Zyrus\Route\Router;

class Kernel
{
    private $app;

    private $router;

    protected $singletonClasses = [];

    public function __construct(Application $app, Router $router)
    {
        $this->app = $app;

        $this->router = $router;

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
        require_once $this->app->getBasePath() . DIRECTORY_SEPARATOR . 'route.php';
    }


    public function handle(Request $request)
    {
        try {
            $response = $this->router->dispatch($request);
            return $response;
        } catch (NotFoundException $exception) {
            return $exception->render();
        }
    }
}