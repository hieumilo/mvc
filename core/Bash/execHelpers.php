<?php

if(!function_exists('createServerCli')) {
    function createServerCli($argv)
    {
        $host = '127.0.0.1';
        $port = '8000';
        foreach ($argv as $param) {
            if (strpos($param, '--host=') !== false) {
                $host = str_replace('--host=', '', $param);
            }
            if (strpos($param, '--port=') !== false) {
                $port = str_replace('--port=', '', $param);
            }
        }
        system("echo " . "Starting development at: http://{$host}:{$port}");
        exec("open " . "http://{$host}:{$port}");
        system("php -S {$host}:{$port} server.php");
    }
}
