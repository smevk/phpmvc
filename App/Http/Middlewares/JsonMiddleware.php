<?php

namespace Php\Mvc\App\Http\Middlewares;

use Php\Mvc\App\Http\Services\Response;

class JsonMiddleware implements Middleware
{
    public function handle($request,  $response, $next)
    
    {
        
         $next($request, $response);
        // Set the Content-Type header to JSON
        header('Content-Type: application/json');
      
        // Call the next middleware or controller action
        return $response;
    }
}
