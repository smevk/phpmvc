<?php
namespace Php\Mvc\App\Http\Middlewares;

class AddDetailsToRequest
{

    public function handle($request, $response, $next)
    {

        $request->setAttribute('keykashif', 'value');
        // passign updated request and response
        $next($request, $response);
        return [$request, $response];
    }
}