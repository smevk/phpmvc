<?php
namespace Php\Mvc\App\Http\Services;

use Php\Mvc\App\Core\UrlParser;

class Request {
    private $attributes = [];
    private $headers = [];
  

    public function setAttribute($name, $value) {
            if (array_key_exists($name, $this->attributes)) {
            // Update the existing attribute
                $this->attributes[$name] = $value;
                $this->$name = $value;
            } else {
                // Add a new attribute
                $this->attributes[$name] = $value;
                $this->$name = $value;
            }

    }

    public function __get($key) {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        return null; // or throw an exception
    }


    // below methods are just for utilitly purpose
        
    public function getAttribute($name) {
        return $this->attributes[$name] ?? null;
    }

    public function get($name) {
        return $this->getAttribute($name);
    }
 
    public function getAllData(){
        return $this->attributes;
    }

    public function setAllData(array $data){
        $this->attributes = $data;
    }
    public function requestFiles(){
        return $_FILES ?? NULL;
    }

    public function queryParams(){
        return UrlParser::$params ?? null;
        
    }
    function getHeaders() {
        if (function_exists('getallheaders')) {
            return getallheaders();
        } else {
            $headers = [];
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
            return $headers;
        }
    }

    public function setHeader($name, $value) {
        $this->headers[strtolower($name)] = $value;
    }


    public static function createFromGlobals() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $queryParams = $_GET;
        $headers = getallheaders();
        $body = file_get_contents('php://input');
        return new Request($method, $uri, $queryParams, $headers, $body);
    }

   

    public function header($header) {
        $headers = $this->getHeaders();
        return $headers[$header] ?? null;
    }   
}
