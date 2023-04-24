<?php

namespace Php\Mvc\App\Http\Middlewares;

use Php\Mvc\App\Http\Services\Request;
use Php\Mvc\App\Http\Services\Response;

class ModifyRequestHeader implements Middleware
{
    public function handle($request, Response $response, $next)
    {
        // Set the X-Powered-By header
        $next($request, $response);
        $response->setHeader('X-Powered-Bys', 'My Awesome MVC');

        // Call the next middleware in the chain
        return $response;
    }

}
