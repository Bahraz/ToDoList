<?php

namespace Bahraz\ToDoApp\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database {
    
    private PDO $connection;

    public function __construct() {
            try{
                $this->connection = new PDO(
                    "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']};charset={$_ENV['DB_CHARSET']}",
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASS']
                );
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new RuntimeException('Database connection failed: ' . $e->getMessage());
            }
    }

    public function getConnection(): PDO {
        return $this->connection;
    }

    public function query(string $sql, array $params = []): bool
    {
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($params);
    }

    public function fetch(string $sql, array $params = []): ?array 
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function fetchAll(string $sql, array $params = []): array 
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function fetchObject(string $sql, array $params = [], string $class): ?object{
        $stmt= $this->connection->prepare($sql);
        $stmt->execute($params);

        if (!class_exists($class)) {
            return null;
        }
    
        $stmt->setFetchMode(PDO::FETCH_CLASS, $class);
        return $stmt->fetch() ?: null;
    }

    public function fetchAllObjects(string $sql, array $params = [], string $class): array {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        if (!class_exists($class)) {
            return [];
        }

        return $stmt->fetchAll(PDO::FETCH_CLASS, $class);
    }

    public function lastInsertId(): string 
    {
        return $this->connection->lastInsertId();
    }
}