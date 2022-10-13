<?php

namespace Zyrus\Application;

use Zyrus\Facades\Facade;

class Application extends Container
{
    protected $basePath;


    public function __construct($path)
    {
        $this->basePath = $path;
        $this->bootstrapApplication();
    }


    /**
     * Bootstrap Application class
     * @return void
     */
    protected function bootstrapApplication()
    {
        $this->mergeAliases();
        $this->logInstance($this->getAlias(get_class($this)), $this);
        $this->resolved(get_class($this));
        static::setInstance($this);
        $this->registerProviders();
    }


    /**
     * Returns the base path of the application
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    public function registerProviders()
    {
        foreach ($this->getDefaultProviders() as $provider) {
            $this->register($provider);
        }
    }


    public function register($provider)
    {
        $serviceProvider = new $provider($this);
        $serviceProvider->register();
    }

    public function getDefaultProviders()
    {
        return [
            'Zyrus\Route\RouteServiceProvider'
        ];
    }
}