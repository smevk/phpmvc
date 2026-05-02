<?php

namespace Php\Mvc\App\Providers;

class Container {
    protected $bindings = [];
    protected $instances = [];


    //binding class name and call back function into protected $bindings array; 
    public function bind($className, $callback){
        $this->bindings[$className] = $callback;
    }

    // singleton will new the class only once and store the object in $instances array;
    // it then check if one object of singleton exist it should return it.
    // if it does not exist then it will exute $callback($container) and store it in instances array;
    public function singleton($className, $callback){
        // first it check if there is instance of current class. it returns that 
        $this->bindings[$className] = function($container) use ($callback,$className){
            if(!isset($this->instances[$className])){
                $this->instances[$className] = $callback($container);
            }
             return $this->instances[$className];
        };
    }


    
    
    


    // make return new object by executing the callback($this) in bindings array.
    public function make($className) {


        if(isset($this->bindings[$className])) {
            $classCallBack = $this->bindings[$className];

            return $classCallBack($this);
        }

        return null;
    }

   

    // helper methods to automatically detect the dependecies of class method UserController@store(Request $request)
    // it will instanitate Request class if its bind in our arrya
    // this method returns all the dependencies  required for method
    // return $dependencies[];
    public function resolveMethodDependencies($className, $methodName, $parameterValues = []) {

        $reflection = new \ReflectionMethod($className, $methodName);
        $dependencies = [];
    
        foreach ($reflection->getParameters() as $parameter) {
            $type = $parameter->getType();
    
            if (isset($parameterValues[$parameter->getName()])) {
                // Overwrite parameter value if provided
                $dependencies[] = $parameterValues[$parameter->getName()];
            } else if ($type) {
                $dependencies[] = $this->make($type->getName());
            } else if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                $dependencies[] = $parameter->getName();
            }
        }
    
       
        return $dependencies;
    }

    // its same helper method as above . it resolve class constructor depenedcies
    // store in defendecies array;
    public function resolveConstructorDependencies($className, $parameterValues = []) {
        $reflection = new \ReflectionClass($className);
        $constructor = $reflection->getConstructor();
        if (!$constructor) {
            return [];
        }
        $dependencies = [];


        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();
    
            if (isset($parameterValues[$parameter->getName()])) {
                // Overwrite parameter value if provided
                $dependencies[] = $parameterValues[$parameter->getName()];
            } else if ($type) {
                $dependencies[] = $this->make($type->getName());
            } else if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                $dependencies[] = $parameter->getName();
            }
        }
    
        return $dependencies;
    }



    // this method execute class and its method along with dependencies
    // its like calling UserController@store(Request,$request,$user_id);
    // Request,$request,$user_id are stored in dependecies array return by
    // resolveMethodDependencies()
    public function resolveMethod($instance, $methodName, $dependencies = []) {
        return call_user_func_array([$instance, $methodName], $dependencies);
    }
}
