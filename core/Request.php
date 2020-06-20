<?php

namespace Core;

class Request
{
    public static $instance;

    public static function getInstance()
    {
        if(!static::$instance) {
            static::$instance = new static;
        }
        return static::$instance;
    }
    
    public function __construct()
    {
        foreach(self::getRequest() as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * Make response array with the request data.
     *
     * @make array $request
     */
    public static function getRequest()
    {
        return $_REQUEST;
    }

    /**
     * Return response array with all request data.
     *
     * @return array $request
     */
    public static function all()
    {
        return self::getRequest();
    }

    /**
     * Response only 1 data input from param.
     *
     * @param string $input
     * @return string input value
     */
    public static function input($input)
    {
        foreach (self::getRequest() as $name => $value) {
            if ($name == $input) {
                return $value;
            }
        }
    }

    /**
     * Response only data input from array input.
     *
     * @param array $input
     * @return array string input value
     */
    public static function only($array_input)
    {
        foreach (self::getRequest() as $name => $value) {
            if (in_array($name, $array_input)) {
                $request[$name] = $value;
            }
        }
        return (object) $request;
    }

    /**
     * Response data input except array input.
     *
     * @param array $input
     * @return array string input value
     */
    public static function except($array_input)
    {
        foreach (self::getRequest() as $name => $value) {
            if (!in_array($name, $array_input)) {
                $request[$name] = $value;
            }
        }
        return (object) $request;
    }

    /**
     * check request is xmlhttprequest
     *
     * @param array $input
     * @return array string input value
     */
    public static function xmlhttprequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
}
