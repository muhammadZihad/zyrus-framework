<?php

namespace Zyrus\Route;

class Route
{
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $regex;
    /**
     * @var array
     */
    private $variables = [];
    /**
     * @var array
     */
    private $action = [];

    /**
     * @var string
     */
    private $method;

    /**
     * @param $url
     * @param $method
     * @param $action
     */
    public function __construct($url, $method, $action)
    {
        $this->setUrl($url);
        $this->setMethod($method);
        $this->setAction($action);
        $this->compileUri($url);
    }

    /**
     * @param $action
     * @return void
     */
    private function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Set route method
     *
     * @param $method
     * @return void
     */
    private function setMethod($method)
    {
        $this->method = $method;
    }


    /**
     * Compile url
     *
     * @param $url
     * @return void
     */
    private function compileUri($url)
    {
        $this->setRegex($this->extractUriRegex($url));
        $this->setVariables($this->extractVariables($url));
    }

    /**
     * Set url regex
     * @param string $regex
     * @return void
     */
    private function setRegex(string $regex)
    {
        $this->regex = $regex;
    }

    /**
     * Extract equivalent regex of given url
     *
     * @param $url
     * @return array|string|string[]|null
     */
    private function extractUriRegex($url)
    {
        $regex = preg_replace(['/^[\/]*/', '/[\/]+$/'], '', preg_replace('/\{\w+\}/', "\w+", $url));
        $regex = preg_replace('/\/\/*/', '\/', $regex);
        return '/^' . $regex . '$/';
    }

    /**
     * Set url
     *
     * @param $url
     * @return void
     */
    private function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get the url for the route
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get regex of the route
     * @return string
     */
    public function getRegex(): string
    {
        return $this->regex;
    }

    /**
     * Get variables for the route
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * Get actionables for the route
     * @return array
     */
    public function getAction(): array
    {
        return $this->action;
    }

    /**
     * Get request method
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Matches the route url to the given url
     *
     * @param string $requestUrl
     * @return false|int
     */
    public function matches($requestUrl)
    {
        return preg_match($this->getRegex(), $this->trimUrl($requestUrl));
    }

    /**
     * Extract variables from url
     * @param string $url
     * @return array
     */
    private function extractVariables($url): array
    {
        if (preg_match_all('/{(\w+)}/', $url, $matches) === false) {
            return [];
        }
        return array_unique($matches[1]);
    }

    /**
     * Set variables
     *
     * @param array $variables
     * @return void
     */
    private function setVariables(array $variables): void
    {
        $this->variables = $variables;
    }

    /**
     * Trim the url to remove forward slash
     *
     * @param string $url
     * @return string
     */
    private function trimUrl(string $url): string
    {
        return rtrim(ltrim($url, "/"), "/");
    }
}
