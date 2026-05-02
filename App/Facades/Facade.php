<?php
namespace Php\Mvc\App\Facades;

use Php\Mvc\App\Providers\Container;

class Facade
{
    
  protected static $container;
  protected static $resolvedInstance;

  
  public static function setContainer($container){
    static::$container = $container;
  }
  
  protected static function getFacadeAccessor(){
    throw new \RuntimeException('Facade does not implement getFacadeAccessor method.');
  }
  
  public static function getFacadeRoot(){
    return static::resolveFacadeInstance(static::getFacadeAccessor());
  }
  
  protected static function resolveFacadeInstance($name){
    if (is_object($name)) {
      return $name;
    }
    
    if (isset(static::$resolvedInstance[$name])) {
      return static::$resolvedInstance[$name];
    }
    
    return static::$resolvedInstance[$name] = static::$container->make($name);
  }
  
  public static function __callStatic($method, $args){
    $instance = static::getFacadeRoot();
    
    if (! $instance) {
      throw new \RuntimeException('A facade root has not been set.');
    }
    
    return $instance->$method(...$args);
  }
  

}

