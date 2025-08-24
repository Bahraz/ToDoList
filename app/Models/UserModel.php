<?php

namespace Bahraz\ToDoApp\Models;

use Bahraz\ToDoApp\Core\Database;
class UserModel {
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function findUserByEmail(string $email): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM users WHERE email = :email",
            [':email' => $email]);
    }

    public function verifyUserPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function createUser(string $email, string $password): bool
    {
        $hashedPassword = $this->hashPassword($password);
        return $this->db->query(
            "INSERT INTO users (email, password) VALUES (:email, :password)", 
            [':email' => $email, ':password' => $hashedPassword]);
    }
}