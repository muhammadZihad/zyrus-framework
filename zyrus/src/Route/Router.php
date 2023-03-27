<?php

namespace Zyrus\Route;

use Zyrus\Exceptions\BindingException;
use Zyrus\Application\Application;
use Zyrus\Exceptions\MethodNotFoundException;
use Zyrus\Request\Request;
use Zyrus\Exceptions\RouteNotFoundException;

class Router
{
    protected $app;

    protected $request;

    /**
     * @var array<Route>
     */
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
        $route = new Route($url, $type, $callback);
        $this->routes[$type][] = $route;
    }


    /**
     * Returns all the registered route
     * @return array;
     */
    public function getAllRoutes()
    {
        return $this->routes;
    }


    public function dispatchRoute($request)
    {
        return $this->runRoute($request, $this->findRoute($request));
    }

    /**
     * @param Request $request
     * @param Route $route
     * @return mixed
     * @throws MethodNotFoundException
     */
    public function runRoute(Request $request, Route $route)
    {
        $action = $route->getAction();

        $controller = $this->app->make($action[0]);

        $method = $action[1];

        if (!method_exists($controller, $method)) {
            throw new MethodNotFoundException("$action[0] Does not have {$method} method.");
        }

        return $controller->$method();
    }

    /**
     * Find matching route
     *
     * @param Request $request
     * @return Route
     * @throws RouteNotFoundException
     */
    public function findRoute(Request $request)
    {
        $method = strtolower($request->getMethod());

        if (!array_key_exists($method, $this->routes)) {
            throw new RouteNotFoundException("Route Not Found");
        }

        $requestUri = $request->server->getRequestUri();

        foreach ($this->routes[$method] as $route) {
            if ($route->matches($requestUri)) {
                return $route;
            }
        }

        throw new RouteNotFoundException("Route Not Found");
    }


    public function dispatch($request)
    {
        $this->request = $request;
        return $this->dispatchRoute($request);
    }
}
