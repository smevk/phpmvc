<?php
namespace Php\Mvc\App\Http\Models;

use Php\Mvc\App\Database\DatabaseFunctions;

class Model extends DatabaseFunctions {
    

    protected $requestAttributes = [];

    public function __set($name, $value)
    {
        $this->requestAttributes[$name] = $value;
    }

    public function __get($name = "")
    {
        return 'haah';
        // return isset($this->requestAttributes[$name]) ? $this->requestAttributes[$name] : null;
    }

    


   
   
 
}