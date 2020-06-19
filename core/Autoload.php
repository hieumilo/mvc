<?php

class Autoload
{
    private $root;
    private $autoload;
    private $server;

    public function __construct()
    {
        $this->setConfig();
        $this->autoloadFile();
        $this->registerAutoload();
    }

    /**
     * Set local config
     *
     * @return void
     */
    private function setConfig()
    {
        $this->root = dirname(dirname(__FILE__));
        $this->autoload = [
            'core/Route.php',
            'routes/routes.php',
        ];
        $this->server = 'windows';
    }

    /**
     * Register function autoload
     *
     * @return void
     */
    private function registerAutoload()
    {
        spl_autoload_register([$this, 'load']);
    }

    /**
     * Autoload class
     * @param string $class
     *
     * @return void
     */
    public function load($class)
    {
        switch ($this->server) {
            case 'linux':
            case 'macosx':
                $file = $this->getUnixPath($class);
                break;
            case 'windows':
                $file = $this->getWindowsPath($class);
                break;
        }
        $this->requireAfterCheckExists($file);
    }

    /**
     * Create the Unix operation path file
     * @param string $class
     *
     * @return string
     */
    private function getUnixPath(string $class)
    {
        return "$this->root/" . str_replace('\\', '/', lcfirst($class) . '.php');
    }

    /**
     * Create the Windows path file
     * @param string $class
     * 
     * @return string
     */
    private function getWindowsPath(string $class)
    {
        return "{$this->root}\\{$class}.php";
    }

    /**
     * Autoload class
     *
     * @return void
     */
    private function autoloadFile()
    {
        try {
            foreach ($this->defaultFile() as $file) {
                $fullUrl = $this->getPathFromFile($file);
                $this->requireAfterCheckExists($fullUrl);
            }
        } catch (\Throwable $th) {
            toPre($th->getMessage());
        }
    }

    /**
     * Check exists file and require
     * 
     * @param string $fullUrl
     * 
     * @return \PDOInstance
     */
    private function requireAfterCheckExists(string $fullUrl)
    {
        if (file_exists($fullUrl)) {
            require_once $fullUrl;
        } else {
            throw new \Exception("File {$fullUrl} doesn't exists.");
        }
    }


    /**
     * Get full the path from file
     * @param string $file
     *
     * @return string
     */
    private function getPathFromFile(string $file)
    {
        return $this->root . '/' . $file;
    }

    /**
     * Get the default file load
     *
     * @return array
     */
    private function defaultFile()
    {
        return $this->autoload;
    }
}
