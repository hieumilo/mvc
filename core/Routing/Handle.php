<?php

namespace core\Routing;

class Handle
{
    public function __construct($routeParams, $requestParams, $action)
    {
        $pazeROUTE = explode('/', $routeParams);
        $pazeREQUEST = explode('/', $requestParams);
        $params = [];
        foreach ($pazeROUTE as $key => $value) {
            if (preg_match('/^{\w+}$/', $value)) {
                $params[] = $pazeREQUEST[$key];
            }
        }
        if (is_callable($action) && is_array($action) || is_string($action)) {
            return new Compile($action, $params);
        } elseif (is_callable($action)) {
            return call_user_func_array($action, $params);
        } else {
            $action = isset($action[1]) ? $action[1] : $action;
            $action = is_array($action) && count($action) == 1 ? $action[0] : $action;
            die("The $action doesn't exists !");
        }
    }
}
