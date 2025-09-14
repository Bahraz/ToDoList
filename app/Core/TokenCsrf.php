<?php

namespace Bahraz\ToDoApp\Core;

class TokenCsrf
{
    public static function generateCsrf(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['TokenCsrf'])) {
            $_SESSION['TokenCsrf'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['TokenCsrf'];
    }

    public static function validateCsrf(?string $token): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['TokenCsrf']) && hash_equals($_SESSION['TokenCsrf'], $token ?? '');
    }
}