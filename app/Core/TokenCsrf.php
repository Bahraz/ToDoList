<?php

namespace Bahraz\ToDoApp\Core;

class TokenCsrf
{
    private const SESSION_KEY = '_csrf_token';
    private const TOKEN_EXPIRY = 3600; 

    public static function generateCsrf(): string
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }

        $token = bin2hex(random_bytes(32));
        $_SESSION[self::SESSION_KEY] = [
            'value' => $token,
            'time' => time() + self::TOKEN_EXPIRY
        ];

        return $token;
    }

    public static function getCsrf(): string
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }

        if(!isset($_SESSION[self::SESSION_KEY]) || self::expiredCsrf())
        {
            return self::generateCsrf();
        }

        return $_SESSION[self::SESSION_KEY]['value'];
    }

    public static function expiredCsrf(): bool
    {
        return (time() - $_SESSION[self::SESSION_KEY]['time']) > self::TOKEN_EXPIRY;
    }

    public static function verifyCsrf(?string $token): bool
    {
        if(session_status() !== PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        
        if(!$token || !isset($_SESSION[self::SESSION_KEY]))
        {
            return false;
        }

        if (self::expiredCsrf())
        {
            unset($_SESSION[self::SESSION_KEY]);
            return false;
        }

        return hash_equals($_SESSION[self::SESSION_KEY]['value'], $token);
    }
}