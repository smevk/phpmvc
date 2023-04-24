<?php

namespace Php\Mvc\App\Core;

abstract class UrlParser {
    public static $basePath;
    public static $path;
    public static $fullUrl;
    public static $url;
    public static $params = array();
    public static $requestMethod;
    public static $requestQueryString;
    public static $documentRoot;
    public static $baseUrl;
    public static $https;
    public static $contentType;

    public static function parseUrl() {
        self::$basePath = $_SERVER['REQUEST_URI'];
        self::$baseUrl = $_SERVER['SERVER_NAME'];
        self::$requestQueryString = $_SERVER['QUERY_STRING'];
        self::$documentRoot = $_SERVER['DOCUMENT_ROOT'];
        self::$requestMethod = $_SERVER['REQUEST_METHOD'];
        parse_str(self::$requestQueryString,$output);
        self::$path = $output['url'];
        unset($output['url']);
        self::$params = $output;
        self::$https = $_SERVER['HTTPS'];
        self::$fullUrl = (self::$https == 'on'? 'https://' : 'http://').self::$baseUrl.self::$basePath;
        self::$url = (self::$https == 'on'? 'https://' : 'http://').self::$baseUrl;
        self::$contentType = $_SERVER['CONTENT_TYPE'] ?? "";
    }
}
  