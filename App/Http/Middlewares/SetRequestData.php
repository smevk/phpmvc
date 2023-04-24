<?php

namespace Php\Mvc\App\Http\Middlewares;

use Exception;
use Php\Mvc\App\Core\UrlParser;

class SetRequestData implements Middleware {

    public function handle($request,$response,$next){
        $next($request,$response);
        $this->setFormInput($request);
        $this->setFormFilesUpload($request);
        $this->queryParams($request);
        return $response;   

    }

    public function setFormInput($request){
        if (isset($_POST)) {
            $requestData = $_POST;

            // if request is json then we will encode it to json
            if(UrlParser::$contentType === 'application/json'){
                // Get the request body as JSON
                $jsonData = file_get_contents('php://input');
               
                // Decode the JSON data into an associative array
                $requestData = json_decode($jsonData, true);
               if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON data');
                }
                
            }


            foreach ($requestData as $key => $value) {
                // if(is_string($key)){
                    $request->setAttribute($key, $value);
                    // $request->$key = $value;
                // }
            }
        }

    }

    public function setFormFilesUpload($request){

        if (isset($_FILES)) {
            foreach ($_FILES as $key => $value) {
                if (is_array($value['name'])) {
                    $filesArray = [];
                    $filesCount = count($value['name']);
                    for ($i = 0; $i < $filesCount; $i++) {
                        $filesArray[] = [
                            'name' => $value['name'][$i],
                            'tmp_name' => $value['tmp_name'][$i],
                            'type' => $value['type'][$i],
                            'size' => $value['size'][$i],
                            'error' => $value['error'][$i],
                        ];
                        
                    }
                    $request->setAttribute($key, $filesArray);
                    $request->setAttribute($key.'_is_multiple', true);
                } else {
                    $request->setAttribute($key, $value);
                    $request->setAttribute($key.'_is_multiple', false);

                    
                }


            }
        }

    }

    public function queryParams(&$request){
        $params = $request->queryParams();
        
        // if($params == null) return;
       
        foreach($params as $key => $value){
            // if(is_string($key)){
                $request->setAttribute($key, $value);
                // $request->$key = $value;
            // }
         }  

    }
}