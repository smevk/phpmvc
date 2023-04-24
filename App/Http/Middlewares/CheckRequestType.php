<?php

namespace Php\Mvc\App\Http\Middlewares;

// use Closure;

class CheckRequestType implements Middleware

{
    public function handle($request, $response, $next)
    {
        $next($request,$response);
        // Get the Accept header value
        $acceptHeader = $request->header('Accept');
        // Check if the request is an API request based on the Accept header
        if (strpos($acceptHeader, 'application/json') === 0) {
            $request->setAttribute('is_api_request',true);
            $request->setAttribute('middle_ware_group','api');
        } else {
            $request->setAttribute('is_api_request',false);
            $request->setAttribute('middle_ware_group','web');

        }

        return $response;
    }
}
