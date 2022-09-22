<?php

namespace Zyrus\Request;

class Request
{
    private $method;

    private $attributes = [];

    private $request = [];

    private $query = [];

    private $cookies = [];

    private $files = [];

    private $server = [];

    public function __construct($query = [], $request = [], $attributes = [], $cookies = [], $files = [], $server = [])
    {
        $this->initialize($query, $request, $attributes, $cookies, $files, $server);
    }

    private function initialize($query, $request, $attributes, $cookies, $files, $server)
    {
        $this->query = $query;
        $this->request = $request;
        $this->attributes = $attributes;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->server = $server;
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
}