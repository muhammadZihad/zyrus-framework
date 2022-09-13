<?php

namespace Zyrus\Application;

use Exception;
use ReflectionClass;
use ReflectionNamedType;

class Application
{
    protected $bindings = [];

    protected $resolved = [];

    protected $instances = [];

    protected $aliases = [];


    public function __construct()
    {
        $this->bootstrapApplication();
    }


    /**
     * Bootstrap Application class
     * @return void
     */
    public function bootstrapApplication()
    {
        $this->mergeAliases();
        $this->logInstance('app', $this);
    }

    /**
     * Merge aliases
     * @return void
     */
    public function mergeAliases()
    {
        $this->aliases = array_merge([
            'Zyrus\Application\Application' => 'app'
        ], $this->aliases);
    }


    /**
     * Binds classes to other references
     * @param string abstract
     * @param string $concrete null
     * @return void
     */
    public function bind($abstract, $concrete = null)
    {
        $this->bindings[$abstract] = $concrete ?? $abstract;
    }


    /**
     * Checks if the abstract already has been resolved
     * @param string $abstract
     * @return bool
     */
    public function resolved($abstract)
    {
        return isset($this->resolved[$abstract]);
    }


    /**
     * Make requested abstract class
     * @param @string $abstract
     * @param bool $shared
     * @return mixed
     */
    public function make($abstract, $shared = false)
    {
        return $this->resolve($abstract, $shared);
    }


    /**
     * Resolves passed abstract
     * @param string $abstract
     * @param bool $shared
     * @return mixed
     */
    public function resolve($abstract, $shared = false)
    {
        $alias = $this->getAlias($abstract);
        if ($this->resolved($abstract) && $this->hasInstance($alias)) {
            return $this->getResolved($alias);
        }

        $instance = $this->build($abstract);

        $this->resolved[$abstract] = true;

        if ($shared) {
            $this->logInstance($alias, $instance);
        }
        return $instance;
    }


    /**
     * Returns the passed abstract instance
     * @string
     * @mixed
     */
    public function getResolved($abstract)
    {
        return $this->instances[$abstract];
    }


    /**
     * Checks if the abstract is already instantiated
     * @param string
     * @return bool
     */
    public function hasInstance($abstract)
    {
        return isset($this->instances[$abstract]);
    }


    /**
     * Get alias of an abstract
     * @param string $abstract
     * @return string
     */
    public function getAlias($abstract)
    {
        return isset($this->aliases[$abstract]) ? $this->aliases[$abstract] : $abstract;
    }


    /**
     * Build class from concrete
     * @param string $concrete
     * @return mixed
     * 
     * @throws \Exception
     */
    public function build($concrete)
    {
        if (!class_exists($concrete)) {
            throw new Exception("$concrete Class does not exists.");
        }
        $reflectionClass = new ReflectionClass($concrete);

        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();

        $instances = $this->resolveDependencies($dependencies);

        return $reflectionClass->newInstanceArgs($instances);
    }


    /**
     * Log shared instances
     * @param string abstract
     * @param mixed
     * @return void
     */
    public function logInstance($abstract, $instance)
    {
        $this->instances[$abstract] = $instance;
    }


    /**
     * Resolves dependencies
     * @param array $dependencies
     * @return array
     */
    public function resolveDependencies($dependencies)
    {
        $resolved = [];

        foreach ($dependencies as $dependency) {
            if (is_null($this->getParameterClassName($dependency))) {
                continue;
            }
            $resolved[] = $this->make($this->getParameterClassName($dependency));
        }
        return $resolved;
    }


    /**
     * Provides dependency constructor parameter class name
     * @param \ReflectionParameter $parameter
     * @return string|null
     */
    public function getParameterClassName($parameter)
    {
        $type = $parameter->getType();
        if (!$type instanceof ReflectionNamedType || $type->isBuiltIn()) {
            return null;
        }
        $name = $type->getName();

        return $name;
    }
}