<?php

namespace Php\Mvc\App\Core;

class Config {

    public static function get($key){
        $config = require __DIR__ . '../../../config/app.php';
        return isset($config[$key]) ? $config[$key] : null;

    }
} 