<?php

namespace Zyrus\Request;

use Zyrus\Collection\InputBag;
use Zyrus\Collection\ServerInputBag;

class Request
{
    public $method;

    public $attributes;

    public $request;

    public $query;

    public $cookies;

    public $files;

    public $server;

    public function __construct($query = [], $request = [], $attributes = [], $cookies = [], $files = [], $server = [])
    {
        $this->initialize($query, $request, $attributes, $cookies, $files, $server);
    }

    private function initialize($query, $request, $attributes, $cookies, $files, $server)
    {
        $this->query = new InputBag($query);
        $this->request = new InputBag($request);
        $this->attributes = new InputBag($attributes);
        $this->cookies = new InputBag($cookies);
        $this->files = new InputBag($files);
        $this->server = new ServerInputBag($server);
        $this->setMethod();
    }


    /**
     * Capture the request
     */
    public static function capture()
    {
        return static::createFromGlobal();
    }

    public static function createFromGlobal()
    {
        // $_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER
        return new static($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);
    }

    public function setMethod()
    {
        $this->method = $_SERVER["REQUEST_METHOD"];
    }

    public function getMethod()
    {
        return $this->method;
    }


    public function all()
    {
        return array_merge($this->query->toArray(), $this->request->toArray());
    }


    public function __get($name)
    {
    }
}