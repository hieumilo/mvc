<?php

namespace core\Routing;

class HandleRoute
{
    public $flag = false;

    public function __construct($routes = null)
    {
        app()->routes = $routes;
        if($routes) {
            return new Route($routes);
        }
    }

}
