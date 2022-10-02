<?php

namespace Zyrus\Route;

use Zyrus\Exceptions\BindingException;
use Zyrus\Application\Application;
use Zyrus\Request\Request;

class Router
{
    protected $app;

    protected $request;

    protected $routes = [
        'get' => [],
        'post' => [],
        'put' => [],
        'patch' => [],
        'delete' => [],
    ];


    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function get($uri = '/', $callback = [])
    {
        if (isset($this->routes['get'][$uri])) {
            return;
        }

        if (is_array($callback) && count($callback) !== 2) {
            throw new BindingException("Callback array should be [Controller::class, 'method'");
        }

        if (is_array($callback)) {
            return $this->setRoute('get', $uri, $callback);
        }

        if (is_string($callback)) {
            $callableArray = explode('@', $callback);
            if (count($callableArray) === 2) {
                return $this->setRoute('get', $uri, $callableArray);
            }
            throw new BindingException("Callback string should be 'Controller@method");
        }
        throw new BindingException("Invalid route callback parameter");
    }

    protected function setRoute($type, $url, $callback)
    {
        $this->routes[$type][$url] = $callback;
    }


    /**
     * Returns all the registered route
     * @return array;
     */
    public function getALlRoutes()
    {
        return $this->routes;
    }


    public function processRoute()
    {
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }
}