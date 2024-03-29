<?php

namespace App;

use Exception;
use PDO;
use PDOException;

class DB
{
    /** @var PDO $connection */
    private $connection = null;

    /** @var DB $instance */
    private static $instance = null ;

    private function __construct() {
    }

    /**
     * @throws Exception
     */
    private function init()
    {
        $host             = config('database', 'mysql', 'host');
        $username         = config('database', 'mysql', 'username');
        $password         = config('database', 'mysql', 'password');
        $db               = config('database', 'mysql', 'db');
        $this->connection = new PDO("mysql:host=$host;dbname=$db", $username, $password);
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$db", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(),$e->getCode());
        }
    }
    
    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection ;
    }
    
    public static function getInstance() {
        if (isset(self::$instance)){
            return self::$instance;
        }
        else {
            $db = new DB();
            $db->init();
            return $db;
        }
    }
}
