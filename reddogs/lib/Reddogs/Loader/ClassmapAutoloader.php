<?php

class Reddogs_Loader_ClassmapAutoloader
{
    private $classmap;

    public function __construct(array $classmap = array())
    {
        $this->classmap = $classmap;
    }
    
    public function getClassmap()
    {
        return $this->classmap;
    }
    
    public function register()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    public function autoload($class)
    {
        if (isset($this->classmap[$class])) {
            require_once $this->classmap[$class];
        }
    }
}