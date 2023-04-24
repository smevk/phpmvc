<?php

namespace Php\Mvc\App\Http;

use Php\Mvc\App\Core\Kernel as CoreKernel;
use Php\Mvc\App\Http\Middlewares\AddDetailsToRequest;
use Php\Mvc\App\Http\Middlewares\AuthMiddleware;
use Php\Mvc\App\Http\Middlewares\JsonMiddleware;
use Php\Mvc\App\Http\Middlewares\ModifyRequestHeader;
use Php\Mvc\App\Http\Middlewares\SensorBadWords;
use Php\Mvc\App\Http\Middlewares\SetRequestData;
use Php\Mvc\App\Http\Middlewares\TransformsResponse;
use Php\Mvc\App\Http\Middlewares\XPoweredByMiddleware;

class Kernel extends CoreKernel {


    protected $middleware = [
      XPoweredByMiddleware::class,
      ModifyRequestHeader::class,
      // AddDetailsToRequest::class,
      // SensorBadWords::class,
      SetRequestData::class,
      // AuthMiddleware::class,
      TransformsResponse::class,
      
    ];

    protected $middlewareGroups = [
      'web' => [


      ],
      'api' => [
        JsonMiddleware::class,

      ] 
    ];

}