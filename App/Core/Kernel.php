<?php
namespace Php\Mvc\App\Core;

use Exception;
use Php\Mvc\App\Http\Middlewares\CheckRequestType;
use Php\Mvc\App\Http\Services\Response;
use Php\Mvc\App\Http\Services\Route;

class Kernel {
    protected $middleware = [];
    protected $middlewareGroups = [];
    protected $isRouteCalled = false; //route in this class is called multiple for some reason so we check it here
    protected $responseArray  = [];
    

    public function handle($request)
    {

        
        $response = new Response();
       
        // Create a new Response object
        
            // Set up the initial middleware to call
            $next = function ($request, $response) {
                // If there are no more middleware to call, return the response
                $this->route($request,$response);
            };

           
        $this->callMiddlewareExemptedFromMiddleWareArray($request,$response);
        // merging groups middleware into middleware array so that 
        // we will lopp thorugh each middleware and call them

        $middlewareStack = array_merge(
            $this->middleware,
            $this->middlewareGroups[$request->is_api_request ? "api" : 'web']
        );
        foreach ($this->middlewareGroups[$request->is_api_request ? "api": 'web'] as $middleware) {
            
            $this->middleware[] = $middleware;
        }

        
        foreach ($middlewareStack as $middleware) {
            $middlewareInstance = new $middleware();
            
            $next = function ($request, $response) use ($middlewareInstance, $next) {
                return $middlewareInstance->handle($request, $response, $next);
            };
        }

    
        // Call the first middleware, which will in turn call the next middleware, etc.
         return $next($request,$response);
        
        
        // return $response;
    }
    
    private function route($request,&$response)
    {

    // Dispatch the request using the Route class
        try {
            if ($this->isRouteCalled) {
                return;
            }
        
            $this->isRouteCalled = true;
        
            $data = Route::dispatch(UrlParser::$path,UrlParser::$requestMethod,UrlParser::$params,$request);
            $response->setContent($data);

        } catch (Exception $e) {
            $response = new Response();
            $response->setStatusCode(404);
            $response->setContent('Not Found');
            $response->send();
            return $response;
            die();
        
        }

    }


    public function callMiddlewareExemptedFromMiddleWareArray($request,&$response){
        // this method is just to call teh checkrequtype middlware
        // Create a new instance of CheckRequestType middleware
        $checkRequestType = new CheckRequestType();

        // Create a new closure that calls the handle method of CheckRequestType middleware and passes in a closure that calls the first middleware in the chain
        $next = function ($request, $response) use ($checkRequestType) {
            return $checkRequestType->handle($request, $response, function ($request, $response) {
                // If there are no more middleware to call, return the response
                return $this->route($request,$response);
            });
        };
         $next($request, $response);

         
         }
}