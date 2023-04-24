<?php

namespace Php\Mvc\App\Http\Middlewares;

use Php\Mvc\App\Http\Services\Response;

class TransformsResponse implements Middleware
{
    public function handle($request, $response, $next)
    {
       
        $next($request,$response);
        // Check if the response content is an array or object
        $content = $response->getContent();
        if (is_array($content) || is_object($content)) {
            // Set the response content to a JSON-encoded version of the array or object
            $response->setContent(json_encode($content));
            
            // Set the content type header to indicate that the response contains JSON data
            $response->setHeader('Content-Type', 'application/json');
        }

        // Return the response object with the updated content and headers
        return $response;
        // return $next($request,$response);
    }
}
