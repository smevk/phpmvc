<?php
namespace Php\Mvc\App\Http\Middlewares;

use Php\Mvc\App\Http\Services\Response;

class XPoweredByMiddleware implements Middleware
{
    public function handle($request,Response $response, $next)
    {
        $next($request,$response);
        // Set the X-Powered-By header
        $response->setHeader('X-Powered-By', 'My Awesome MVC');

        // Call the next middleware in the chain
        return $response;
    }
}
