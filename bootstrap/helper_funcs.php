<?php

// write helper functions here

use Php\Mvc\App\Core\UrlParser;
use Php\Mvc\App\Http\Services\Request;
use Php\Mvc\App\Http\Services\Route;

function view($view = null, $data = [], $mergeData = [])
{


    include("views/{$view}.php");



}

function parseUrl() {
    Php\Mvc\App\Core\UrlParser::parseUrl();
}

function dispatchRoutes(){
    
Route::dispatch(UrlParser::$path,UrlParser::$requestMethod,UrlParser::$params,new Request());

}