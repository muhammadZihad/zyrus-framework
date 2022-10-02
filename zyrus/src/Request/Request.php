<?php

namespace Zyrus\Request;

use Zyrus\Collection\InputBag;

class Request
{
    private $method;

    private $attributes;

    private $request;

    private $query;

    private $cookies;

    private $files;

    private $server;

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
        $this->server = new InputBag($server);
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

    private function setMethod()
    {
        $this->method = $_SERVER["REQUEST_METHOD"];
    }


    public function all()
    {
        return array_merge($this->query->toArray(), $this->request->toArray());
    }
}