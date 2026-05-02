<?php
namespace Php\Mvc\App\Database;

use PDO;

class DatabaseConnection
{

    protected $connectionStatus;

    protected $pdo;


    public function __construct($options = [])
    {

        $defaultOptions = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];


        $options = array_merge($defaultOptions, $options);

        $host = env('db_host');
        $db_con = env('db_con');
        $db_name = env('db_name');
        $db_pass = env('db_pass');
        $db_user = env('db_user');

        $dsn = "$db_con:host=$host;dbname=$db_name;charset=utf8mb4";

        try {
            $this->pdo = new PDO($dsn, $db_user, $db_pass, $options);

            $this->connectionStatus = 'connected';
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
            $this->connectionStatus = $e->getMessage();

        }
        return $this;

    }


    public function getPdo()
    {
        return $this->pdo;
    }






}