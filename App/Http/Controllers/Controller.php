<?php
namespace Php\Mvc\App\Http\Controllers;

use Php\Mvc\App\Providers\Container;

class Controller {
    protected $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function __call($method, $args)
    {
        $dependencies = $this->container->resolveMethodDependencies(get_class($this), $method);
        return $this->container->resolveMethod($this, $method, $dependencies);
    }
    
}