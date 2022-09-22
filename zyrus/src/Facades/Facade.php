<?php

namespace App\Facades;

use RuntimeException;

abstract class Facade
{

    protected static $resolvedInstances;


    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }


    public static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        if (isset(static::$resolvedInstances[$name])) {
            return static::$resolvedInstances[$name];
        }

        return new $name;
    }


    protected static function getFacadeAccessor()
    {
        throw new RuntimeException('Facade does not implement getFacadeAccessor method.');
    }


    public function __callStatic($method, $arguments)
    {
        $instance = static::getFacadeRoot();

        if (!$instance) {
            throw new RuntimeException('Invalid facade');
        }

        return $instance->$method(...$arguments);
    }
}