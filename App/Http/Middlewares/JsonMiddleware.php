<?php

namespace Php\Mvc\App\Http\Middlewares;

use Php\Mvc\App\Http\Services\Response;

class JsonMiddleware implements Middleware
{
    public function handle($request,$response, $next)
    
    {
        
        // Set the Content-Type header to JSON
        header('Content-Type: application/json');
      
        // passign updated request and response
        $next($request,$response);
        return [$request,$response];  

    }
}
