<?php
namespace Php\Mvc\App\Http\Middlewares;

class SensorBadWords implements Middleware{

    public function handle($request, $response, $next){
        
        
        // $request = $middlewareCall[0];
        // $response = $middlewareCall[1];
        // Sensor request data       
        $this->sensorRequestData($request);
        // Sensor response data
        $this->sensorResponseData($response);

        // passign updated request and response
        $next($request,$response);
        return [$request,$response];   

    }


    public function sensorRequestData($request){

        $requestData = $request->getAllData();
      
        foreach ($this->badWords() as $key => $value) {
            $requestData = @str_replace($key, $value, $requestData);
        }
        $request->setAllData($requestData);
    }

    public function sensorResponseData($response){
        $responseData = @$response->getContent();
        foreach ($this->badWords() as $key => $value) {
            $responseData = @str_replace($key, $value, $responseData);
        }
        $response->setContent($responseData);
    }

    public function badWords() {
        return [
            'fucking' => 'love',
            'bad' => 'good',
            'hell' => 'heaven'
        ];
    }
}
