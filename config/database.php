<?php

namespace config;

use PDO;

class Database
{
    private $host = 'localhost';
    private $db = 'library';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    private $dsn;
    private $options;
    public $pdo;

    public function __construct()
    {
        $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $this->options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }

    public function connect()
    {
        try {
            $this->pdo = new PDO($this->dsn, $this->username, $this->password, $this->options);
            return $this->pdo;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}


$db_connect = new Database();
$pdo = $db_connect->connect();
