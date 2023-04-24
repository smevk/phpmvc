<?php
namespace Php\Mvc\App\Traits;

use Php\Mvc\App\Core\UrlParser;

/**
 * it containts http request methods
 */
trait HttpReqsMethods
{
    protected static $routeArray;

    public static function get($uri, $action) {
        
        return self::pushToRoute($uri,$action,"GET");
     }
     public static function post($uri, $action) {
         return self::pushToRoute($uri,$action,"POST");
      }
     public static function delete($uri, $action) {
         return self::pushToRoute($uri,$action,"DELETE");
      }
     public static function put($uri, $action) {
         return self::pushToRoute($uri,$action,"PUT");
      }


      public static function pushToRoute($uri,$action,$method){
          self::$routeArray[] = [
              'route' => $uri,
              'action' => $action,
              'method' => $method,
              
          ];

  
      }
      public static function getRoutes(){
      }
}
