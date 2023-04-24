<?php

// Start the session

use Php\Mvc\App\Http\Kernel;
use Php\Mvc\App\Http\Services\Request;

session_start();
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/helper_funcs.php';
require __DIR__.'/Routes/web.php';


parseUrl();
// dispatchRoutes();


// Create a new request object
$request = Request::createFromGlobals();

// Create a new kernel instance
$kernel = new Kernel();

// Call the kernel's handle method, passing in the request
$response = $kernel->handle($request);
// Send the response back to the client
$response->send();