<?php

namespace config;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;

    // Конфигурация в приватных константах
    private const HOST = 'localhost';
    private const DB_NAME = 'library';
    private const USER = 'root';
    private const PASS = '';
    private const CHARSET = 'utf8mb4';

    private function __construct()
    {
        $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DB_NAME . ";charset=" . self::CHARSET;

        try {
            $this->pdo = new PDO(
                $dsn,
                self::USER,
                self::PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_STRINGIFY_FETCHES => false
                ]
            );
        } catch (PDOException $e) {
            // Логирование ошибки
            error_log("Database connection failed: " . $e->getMessage());
            throw new PDOException("Database connection error");
        }
    }

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }

    // Запрещаем клонирование и восстановление
    private function __clone() {}
    public function __wakeup() {}
}
