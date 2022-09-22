<?php

namespace App\Route\Facade;

use App\Facades\Facade;

class Route extends Facade
{

    public static function getFacadeAccessor()
    {
        return "Zyrus\Route\Router";
    }
}