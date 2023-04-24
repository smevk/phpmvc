<?php
namespace Php\Mvc\App\Http\Middlewares;

use Php\Mvc\App\Http\Services\Response;

class AuthMiddleware
{
    public function handle($request, Response $response, $next)
    {
        // Check if the user is authenticated, for example by checking if there is a user session
        if (!isset($_SESSION['user'])) {
            // If the user is not authenticated, redirect them to the login page
            $response->setStatusCode(302);
            $response->setHeader('Location', '/login');
            $response->send();
            return $response;
        }

        // If the user is authenticated, call the next middleware
        return $next($request, $response);
    }
}
