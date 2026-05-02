<?php

namespace Php\Mvc\App\Http\Middlewares;

use Exception;
use Php\Mvc\App\Core\UrlParser;

class SetRequestClassDataSource implements Middleware {

    public function handle($request,$response,$next){

        if(isset($_POST)){
            $request->POST = $_POST;
        }
        if(isset($_FILES)){
            $request->FILES = $_FILES;
        }
        if(!empty(UrlParser::$params)){
            $request->QUERYPARAMS = UrlParser::$params;
        }
        // passign updated request and response
        $next($request,$response);
        return [$request,$response]; 
    }
}