<?php

require_once './core/Bash/execHelpers.php';

class BashHandler
{
    private $argv;

    public function __construct()
    {
        global $argv;
        $this->argv = $argv;
    }

    /**
     * execute command
     * 
     * @return void
     */
    public function terminate(): void
    {
        switch (strtolower($this->argv[1])) {
            case 'ser':
            case 'serve':
                createServerCli($this->argv);
                break;
            default:
                # code...
                break;
        }
    }
}
