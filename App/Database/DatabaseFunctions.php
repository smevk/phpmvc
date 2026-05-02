<?php

namespace Php\Mvc\App\Database;

use BadMethodCallException;
use Exception;
use Php\Mvc\App\Http\Services\Request;
use Php\Mvc\App\Providers\Container;
use Php\Mvc\App\Traits\DbQueries;
use ReflectionMethod;

/**
 * @phpstan-ignore-next-line Non static method should not be called statically
 */

class DatabaseFunctions extends DatabaseConnection {

    use DbQueries;
    protected $tableName;
    protected $request;
    // protected $dbMethods = ['get','all','where','orWhere','paginate','find'];
    
    public function __construct()
    {
        parent::__construct();
        // if tableName exisit in model then we will use it
        if (!isset($this->tableName)) {
            // return $this->tableName;
            // if not exist then we will make it based on model class name
            $this->getTableName();
        }

    }
   

    // call staic is used to call non static method in static manner.
    // it works only if the method not exist in class. or is not accessable outside class. e.g private, protected
    // so i made all usefull method protected to make it non accessable. hence callstatic will be called
    // this way I can access non static method in static manner.
        /**
     * This magic method is used to call non-static methods in a static manner. If the method is not accessible outside the class (i.e. it is private or protected), it will be called via the `__call()` method.
     *
     * @param string $method The name of the method to be called.
     * @param array $args The list of arguments to be passed to the method.
     * @return mixed The result of the method call.
     */
    public static function __callStatic($method, $args)
    {
        $instance = new Static(); //creating instance of of DatabaseFunctions class;
        return call_user_func_array([$instance,$method], $args);
    }

    // even if you call non static method in static way. and if you chain it with other methods such as User::where()->get();
    // ->get() will be called non static but it is out of the scope because its protected so we have to call it using  _call 
        /**
     * This magic method is used to call protected and public methods within the class.
     *
     * If the method is not public or protected, a `BadMethodCallException` will be thrown.
     *
     * @param string $method The name of the method to be called.
     * @param array $args The list of arguments to be passed to the method.
     * @return mixed The result of the method call.
     * @throws BadMethodCallException If the method is not accessible.
     */
    public function __call($method, $args)
    {
        $reflection = new ReflectionMethod($this, $method);

        // using below function because __call will call even private function which i dont want.
        if ($reflection->isPublic() || $reflection->isProtected()) {
            return $this->$method(...$args);
        }
    
        throw new BadMethodCallException("Call to undefined method {$method}");
    }

  
    
   public function setRequest(Request $request){
    // this method is just incase you want to access Request class for information
     $this->request = $request;
   }



    protected function getTableName() {
        $classPath = get_class($this);
        $className = strtolower(str_replace('Php\\Mvc\\App\\Http\\Models\\','',$classPath));
     
        if (preg_match('/^.*(?:s|x|z|ch|sh)$/', $className)) {
         $this->tableName =  $className . 'es';
         } elseif (preg_match('/^.*[^aeiou]y$/', $className)) {
             $this->tableName =  substr($className, 0, -1) . 'ies';
         } else {
             $this->tableName = $className . 's';
         }
 
         return $this->tableName;
     }

}