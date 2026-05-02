<?php

use Php\Mvc\App\Http\Kernel;
use Php\Mvc\App\Http\Services\Request;
use Php\Mvc\App\Providers\AppServiceProvider;
use Php\Mvc\App\Providers\Container;
use Php\Mvc\App\Providers\ServiceProvider;

parseUrl();

// Register the bindings
// $container = new Container()/ or use app()

// registering itself the Container class
app()->singleton(Container::class, function($container) {
  // return new Container() app() = new Continer()
    return  app();
  });

app()->singleton(ServiceProvider::class, function($container) {
    return  new ServiceProvider($container);
  });
app()->singleton(AppServiceProvider::class, function($container) {
    return  new AppServiceProvider($container);
  });

app()->make(AppServiceProvider::class)->register();
app()->singleton(Kernel::class,function($container){
     return new Kernel($container);
});


// Call the kernel's handle method, passing in the request and app() = instance of Container class
// outdated Request::class
$response = app()->make(Kernel::class)->handle(app()->make(Request::class),app())[1];
// Send the response back to the client
$response->send();
