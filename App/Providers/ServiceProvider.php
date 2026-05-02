<?php
namespace Php\Mvc\App\Providers;


use Php\Mvc\App\Facades\Facade;
use Php\Mvc\App\Http\Services\Request;
use Php\Mvc\App\Http\Services\Response;

class ServiceProvider {

    protected $container;
    
    public function __construct($contianer){
        $this->container = $contianer;
        
    }

    public function register(){

        // Bind the Request object as a singleton

        $this->container->singleton(Request::class, function($container) {
            return Request::createFromGlobals();
        });
        
        $this->container->singleton(Response::class, function($container) {
            return new Response();
        });
        
        // binding all models at Http\Models to container instand of binding individually
        $this->bindAllClassInADirectory("/../Http/Models/","Php\\Mvc\\App\\Http\Models\\");
       
        // binding all controllers
        $this->bindAllClassInADirectory("/../Http/Controllers/","Php\\Mvc\\App\\Http\Controllers\\");

      
        // binding all classes in databse folder
        $this->bindAllClassInADirectory("/../Database/","Php\\Mvc\\App\\Http\Database\\",'singleton');

        
       
        // bidning all facades to container
        Facade::setContainer($this->container);

    }

    private function bindAllClassInADirectory($directory,$namsespace,$typeOfBinding = "bind"){

        foreach (glob(__DIR__.$directory.'*.php') as $file) {
            $classname = $namsespace . basename($file, '.php');
            $this->container->$typeOfBinding($classname, function($container) use ($classname) {
                // resolving constructor dependencies
                // example UserController($dependencies)
               $constructorDependencies = $container->resolveConstructorDependencies($classname);
                //new Class(destructring dependencies); 
                return new $classname(...$constructorDependencies);
            });
        
        }
    }

}