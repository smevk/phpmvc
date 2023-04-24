<?php

namespace Php\Mvc\App\Http\Services;

class Response
{
    protected $content;
    protected $statusCode;
    protected $headers = [];

    public function __construct($content = '', $statusCode = 200, $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getContent(){
        return $this->content;
    }
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function send()
    {
        // Send HTTP headers
        
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        // Send HTTP status code
        http_response_code($this->statusCode);

        // Send content
        echo $this->content;
    }
}