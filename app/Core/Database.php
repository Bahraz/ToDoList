<?php

namespace Bahraz\ToDoApp\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null){

            $required = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];

            foreach ($required as $key) {
                if (!isset($_ENV[$key])) {
                    throw new RuntimeException("Missing {$key} in environment variables.");
                }

            }
            
            $host = $_ENV['DB_HOST'];
            $db   = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];

            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            try{
                self::$instance = new PDO($dsn, $user, $pass,[
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                throw new RuntimeException('Database connection failed: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}