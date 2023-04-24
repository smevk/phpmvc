<?php
namespace Php\Mvc\App\Http\Middlewares;

class AddDetailsToRequest {

    public function handle($request,$response,$next){
        $next($request,$response);
        
        $request->setAttribute('keykashif','value');
        return $response;
    }
}