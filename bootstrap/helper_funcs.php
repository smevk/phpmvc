<?php

// write helper functions here

use Php\Mvc\App\Core\Config;
use Php\Mvc\App\Core\TemplateEngine;
use Php\Mvc\App\Providers\Container;

/**
 * Summary of view
 * @param mixed $view
 * @param mixed $data
 * @return void
 */
function view($view = null, $data = [])
{
    if ($view !== null) {
        $viewPath = "views/{$view}.php";
        if (file_exists($viewPath)) {
            extract($data);
            include($viewPath);
        } else {
            echo "Error: View file not found.";
        }
    } else {
        echo "Error: No view specified.";
    }
}

/**
 * Summary of parseUrl
 * @return void
 */
function parseUrl()
{
    Php\Mvc\App\Core\UrlParser::parseUrl();
}

function dispatchRoutes()
{

    // Route::dispatch(UrlParser::$path,UrlParser::$requestMethod,UrlParser::$params,new Request());

}

// return new Container()
function app()
{

    // static $container mean it the container class be will be signleton. only one time new ();
    static $container = null;

    if ($container === null) {
        $container = new Container();

    }

    return $container;
}
// helper function return app() function
/**
 * Summary of container
 * @return mixed
 */
function container()
{
    return app();
}


function parseEnvFile($filePath)
{
    $contents = file_get_contents($filePath);
    $lines = explode("\n", $contents);
    $result = [];

    // loop through each line of .env file
    foreach ($lines as $line) {
        // if empty line or contains #for comment then skip it and move to next line
        if (empty($line) || substr($line, 0, 1) === '#') {
            // contine is used to skip current iteration 
            continue;
        }

        // explode it to key and value pair and store it in restlt aray
        $parts = explode('=', $line, 2);
        $key = trim($parts[0]);
        $value = isset($parts[1]) ? trim($parts[1]) : '';

        $result[$key] = $value;
    }

    return $result;
}

function env($key)
{

    return Config::get($key) ?? "";
}