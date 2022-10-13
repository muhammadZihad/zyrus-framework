<?php

namespace Zyrus\Facades;

use App\Exceptions\FacadeHandlerException;
use RuntimeException;
use Zyrus\Application\Application;

abstract class Facade
{
    protected static $app;

    protected static $resolvedInstances;

    public static function setFacadeApplication(Application $app)
    {
        static::$app = $app;
    }

    protected static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }


    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }

        $name = static::$app->getAlias($name);

        if (isset(static::$resolvedInstances[$name])) {
            return static::$resolvedInstances[$name];
        }

        $concrete = static::$app->make($name, true);

        if (is_null($concrete)) {
            throw new FacadeHandlerException("$name could not be resolved");
        }

        static::setResolvedInstances($name, $concrete);

        return $concrete;
    }


    protected static function setResolvedInstances($name, $concrete)
    {
        static::$resolvedInstances[$name] = $concrete;
    }


    protected static function getFacadeAccessor()
    {
        throw new RuntimeException('Facade does not implement getFacadeAccessor method.');
    }


    public static function __callStatic($method, $arguments)
    {
        $instance = static::getFacadeRoot();

        if (!$instance) {
            throw new FacadeHandlerException('Invalid facade');
        }

        return $instance->$method(...$arguments);
    }
}