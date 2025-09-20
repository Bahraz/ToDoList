<?php 

namespace Bahraz\ToDoApp\Core;

use Bahraz\ToDoApp\Core\JsonResponse;

class Auth 
{
    public static function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(int $userId, string $userEmail): void
    {
        self::startSession();
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_email'] = $userEmail;
    }

    public static function logout(): void
    {
        self::startSession();
        session_unset();
        session_destroy();
    }

    public static function check(): bool
    {
        self::startSession();
        return isset($_SESSION['user_id']);
    }

    public static function userId(): ?int
    {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }

    public static function userEmail(): ?string
    {
        self::startSession();
        return $_SESSION['user_email'] ?? null;
    }

    public static function requireLogin(): void
    {
        if(!self::check())
        {
            JsonResponse::error('Unauthorized access.', 401);
            exit;
        }
    }

    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function verifyPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
}