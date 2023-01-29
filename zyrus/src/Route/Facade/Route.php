<?php

namespace Zyrus\Route\Facade;

use Zyrus\Facades\Facade;

/**
 * List of methods available
 * @method static void get($uri = '/', $callback = [])
 * @method static array getALlRoutes($uri = '/', $callback = [])
 * 
 * 
 * @see \Zyrus\Route\Router
 */

class Route extends Facade
{

    public static function getFacadeAccessor()
    {
        return "router";
    }
}