<?php

namespace Zyrus\Route\Facade;

use Zyrus\Facades\Facade;

/**
 * List of methods available
 * @method static void get()
 * @method static array getALlRoutes()
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