<?php

use core\Routing\Compile;
use core\Routing\HandleRoute;

class Route
{
    private $uri;

    private $action;

    private $method;

    private $name;

    private static $routes = [];

    public function __construct($uri = null, $action = null, $method = 'GET')
    {
        $this->uri = $uri;
        $this->action = $action;
        $this->method = $method;
    }

    /**
     * Register get route
     *
     * @param string $uri
     * @param string $action
     *
     * @return $this
     */
    public static function get($uri, $action)
    {
        return new self($uri, $action, 'GET');
    }

    /**
     * Register post route
     *
     * @param string $uri
     * @param string $action
     *
     * @return $this
     */
    public static function post($uri, $action)
    {
        return new self($uri, $action, 'POST');
    }

    /**
     * Register put route
     *
     * @param string $uri
     * @param string $action
     *
     * @return $this
     */
    public static function put($uri, $action)
    {
        return new self($uri, $action, 'GET');
    }

    /**
     * Register path route
     *
     * @param string $uri
     * @param string $action
     *
     * @return $this
     */
    public static function patch($uri, $action)
    {
        return new self($uri, $action, 'GET');
    }

    /**
     * Register delete route
     *
     * @param string $uri
     * @param string $action
     *
     * @return $this
     */
    public static function delete($uri, $action)
    {
        return new self($uri, $action, 'GET');
    }

    /**
     * Name function
     * @param string $name
     *
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Destruct handle
     *
     * @return void
     */
    public function __destruct()
    {
        if ($this->uri != null) {
            $this->pushRouteToCollections($this->uri, $this->action, $this->method, $this->name);
        }
    }

    /**
     * Push simple route to collection routes
     * @param string $uri
     * @param string $action
     * @param string $method
     * @param string $name
     *
     * @return void
     */
    private function pushRouteToCollections($uri, $action, $method, $name)
    {
        array_push(self::$routes, [
            'uri' => $uri,
            'action' => $action,
            'method' => $method,
            'name' => $name,
        ]);
    }

    /**
     * Start routing
     *
     * @return HandleRoute
     */
    public function run()
    {
        return (new HandleRoute(self::$routes));
    }
}
