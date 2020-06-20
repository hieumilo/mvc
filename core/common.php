<?php

use core\Registry;

if (!function_exists('toPre')) {
    function toPre($collection): void
    {
        print_r($collection);
        exit;
    }
}

if (!function_exists('app')) {
    function app()
    {
        return Registry::getInstance();
    }
}

if (!function_exists('dd')) {
    function dd()
    {
        array_map(function($x) { 
            print_r($x); 
        }, func_get_args());
        die;
    }
}

if (!function_exists('view')) {
    function view($view, $data = null)
    {
        return (new Core\Controller)->render($view, $data);
    }
}

if (!function_exists('redirect')) {
    function redirect($url)
    {
        header('Location: ' . $url);
    }
}
