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

if (!function_exists('assets')) {
    function assets($path)
    {
        if (php_sapi_name() == 'cli-server') {
            return "/public/$path";
        } else {
            return $path;
        }
        throw new Exception("");
    }
}

if (!function_exists('env')) {
    function env($variable)
    {
        $app_base = dirname(dirname(__FILE__));
        $path = $app_base . '/.env';
        if (!file_exists($path)) {
            system("echo " . 'Missing .env file.');
            exit;
        }
        $env = parse_ini_file($path);
        foreach ($env as $key => $value) {
            if ($variable == $key) {
                $result = $value;
                if (!empty($result)) {
                    return $result;
                }
                break;
            }
        }
        return '';
    }
}
