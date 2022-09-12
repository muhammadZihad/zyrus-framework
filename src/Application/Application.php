<?php

namespace Zyrus\Application;

class Application
{
    protected $bindings = [];

    protected $resolved = [];

    protected $instances = [];

    public function bind($abstract, $concrete = null)
    {
        $this->bindings[$abstract] = $concrete ?? $abstract;
    }

    public function resolved($abstract)
    {
        return isset($this->resolved[$abstract]);
    }

    public function make($abstract, $shared = false)
    {
        return $this->resolve($abstract, $shared);
    }


    public function resolve($abstract, $shared = false)
    {

        $instance = $this->build($abstract);
        $this->resolved[$abstract] = true;
        if ($shared) {
            $this->instances[$abstract] = $instance;
        }
        return $instance;
    }

    public function build($concrete)
    {
        if (isset($this->bindings[$concrete])) {
            $concrete = $this->bindings[$concrete];
        }
        return new $concrete;
    }
}