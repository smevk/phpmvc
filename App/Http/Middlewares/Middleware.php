<?php

namespace Php\Mvc\App\Http\Middlewares;

use Php\Mvc\App\Http\Services\Request;
use Php\Mvc\App\Http\Services\Response;

interface Middleware {
    public function handle(Request $request,Response $response,$next);
}