<?php
namespace Php\Mvc\App\Core;

use Exception;
use Php\Mvc\App\Http\Middlewares\CheckRequestType;
use Php\Mvc\App\Http\Services\Response;
use Php\Mvc\App\Http\Services\Route;

class Kernel {
    protected $middleware = [];
    protected $middlewareGroups = [];
    // protected $isRouteCalled = false; //route in this class is called multiple for some reason so we check it here
    

    public function handle($request,$container)
    {

        
        $response = $container->make(Response::class);
       
   
        $checkRequestType = new CheckRequestType();

        // Create a new closure that calls the handle method of CheckRequestType middleware and passes in a closure that calls the first middleware in the chain
        $next = function ($request, $response) use ($checkRequestType,$container) {
            return $checkRequestType->handle($request, $response, function ($request, $response) use($container) {
                // If there are no more middleware to call, return the response
                return $this->route($request,$response,$container);
            });
        };

        
        // merging groups middleware into middleware array so that 
        // we will lopp thorugh each middleware and call them

        $middlewareStack = array_merge(
            $this->middleware,
            $this->middlewareGroups[$request->is_api_request ? "api" : 'web']
        );
        foreach ($this->middlewareGroups[$request->is_api_request ? "api": 'web'] as $middleware) {
            
            $this->middleware[] = $middleware;
        }

        
        // calling middlwares one by one in loop    
        foreach ($middlewareStack as $middleware) {
            $middlewareInstance = new $middleware();            
            $next = function ($request, $response) use ($middlewareInstance, $next) {
                    return $middlewareInstance->handle($request, $response,function($request,$response) use ($next){
                        return $next($request, $response);
                    });
                };

        }



    
        // Call the first middleware, which will in turn call the next middleware, etc.
        
        $next($request,$response);
        
        
        return [$request,$response];
    }
    
    private function route($request,$response,$container)
    {

    // Dispatch the request using the Route class
        try {

            $data = Route::dispatch(UrlParser::$path,UrlParser::$requestMethod,$request,$container);
            $response->setContent($data);
            return [$request,$response];

        } catch (Exception $e) {
            $response = new Response();
            $response->setStatusCode(404);
            $response->setContent($e);
            $response->send();
            return [$request,$response];
            die();
        
        }

    }


}