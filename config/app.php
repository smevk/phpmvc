<?php
$env = parseEnvFile(__DIR__ . '../../.env');
return [

    'app_name' => $env['APP_NAME'],
    'env' => $env['APP_ENV'],
    'debug' => $env['APP_DEBUG'],
    'app_url' => $env['APP_URL'],










    // database related config
    'db_con' => $env['DB_CONNECTION'],
    'db_host' => $env['DB_HOST'],
    'db_port' => $env['DB_PORT'],
    'db_name' => $env['DB_DATABASE'],
    'db_user' => $env['DB_USERNAME'],
    'db_pass' => $env['DB_PASSWORD'],


];