<?php

namespace core\Routing;

use App\Http\Exceptions\Exception;
use App\Http\Kernel;
use core\Http\Request;

class Compile
{
    public function __construct($action = null, array $params = null)
    {
        return $this->handle($action, $params);
    }

    public function handle($action, $params)
    {
        if (!is_array($action)) {
            $action = explode('@', $action);
        }
        switch (count($action)) {
            case 2:
                $className = $action[0];
                $methodName = $action[1];
                $cloud = true;
                break;
            case 1:
                $className = $action[0];
                $methodName = null;
                $cloud = false;
                break;
            default:
                throw new Exception("Controller wrong format !");
                break;
        }
        if (explode('\\', $className)[0] === 'App') {
            $controller = $className;
        } else {
            $controller = 'App\\Http\\Controllers\\' . $className;
        }
        if (class_exists($controller)) {
            $ref = new \ReflectionMethod($controller, $methodName);
            $listParameters = $ref->getParameters();
            if(count($listParameters) > 0 && isset($listParameters[0]) && $listParameters[0]->name === 'request') {
                array_unshift($params, Request::getInstance());
            }
            $object = new $controller;
            if (method_exists($controller, $methodName) && $cloud === true) {
                return call_user_func_array([$object, $methodName], $params);
            }
            if ($cloud === false) {
                return $object($params);
            }
            throw new Exception("Method {$className}@{$methodName} doesn't exists !");
        }
        throw new Exception("Class {$className} doesn't exists !");
    }
}
