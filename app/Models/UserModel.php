<?php

namespace Bahraz\ToDoApp\Models;

use Bahraz\ToDoApp\Core\Database;
use PDO;
use PDOException;
use RuntimeException;

class UserModel{

    public static function findUserByEmail(string $email): ?array
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);

            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }
    }

    public static function verifyUserPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function createUser(string $email, string $password):bool
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
            return $stmt->execute([':email' => $email, ':password' => $password]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }
    }

}