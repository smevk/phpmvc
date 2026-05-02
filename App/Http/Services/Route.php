<?php
namespace Php\Mvc\App\Http\Services;

use Exception;
use Php\Mvc\App\Http\Services\RouteServices;
use Php\Mvc\App\Traits\HttpReqsMethods;

class Route {
    use HttpReqsMethods;
    public static $routeGroup;

  
    public static function dispatch($uri,$method,$request,$container) {
        // Loop through each route in $routeArray
        foreach (self::$routeArray as $route) {
            // checking if method is same or not
             // Replace route parameters with regular expressions
             $pattern = '/^' . str_replace('/', '\/', $route['route']) . '$/';             
             $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^\/]+)', $pattern);
            // Check if the requested URI matches the pattern
            if (preg_match($pattern, $uri, $matches) && $method === $route['method']) {
                // Call the corresponding action for that route
               return self::callClassAndMethod($route,$container,$request,$matches);
            }

        }

        // If no matching route is found, throw an exception
        throw new Exception('404 Not Found');
    }


    public static function callClassAndMethod($route,$container,$request,$matches){
        $action = $route['action'];
        $controller =  $action[0];
        $method = $action[1];
        $paramsArray = [];
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $paramsArray[$key] = $value;
                // $request->setAttribute($key, $value);
            }        
        }
        $dependencies = $container->resolveMethodDependencies($controller, $method,$paramsArray);
        $instance = $container->make($controller);
        return $container->resolveMethod($instance, $method,$dependencies);
    }
  
    
   
}