<?php

namespace Bahraz\ToDoApp\Controllers\Api;

use Bahraz\ToDoApp\Repositories\UserRepository;
use Bahraz\ToDoApp\Core\Database;
use Bahraz\ToDoApp\Core\TokenCsrf;
use Bahraz\ToDoApp\Core\JsonResponse;
use Bahraz\ToDoApp\Entities\User;

class UserController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $db = new Database();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->userRepository = new UserRepository($db);
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private function verifyPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    public function loginUser(): void
    {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);

        if (!TokenCsrf::verifyCsrf($input['TokenCsrf'] ?? '')) {
            JsonResponse::error('Invalid CSRF token.', 403);
            return;
        }

        $email = strtolower($input['email'] ?? '');
        $password = $input['password'] ?? '';
        
        $user = $this->userRepository->findUserByEmail($email);
        
        if ($user && $this->verifyPassword($password, $user->getPassword())) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_email'] = $user->getEmail();

            JsonResponse::success(['message' => 'Login successful'], 200);
        } else {
            JsonResponse::error('Invalid email or password.', 401);
        }
    }

    public function registerUser(): void
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        if (!TokenCsrf::verifyCsrf($input['TokenCsrf'] ?? '')) {
            JsonResponse::error('Invalid CSRF token.', 403);
            return;
        }

        $email = strtolower($input['email'] ?? '');
        $password = $input['password'] ?? '';
        $confirmPassword = $input['confirmPassword'] ?? '';

        if ($this->userRepository->findUserByEmail($email)) {
            JsonResponse::error('Email already in use', 409);
            return;
        }

        if ($password !== $confirmPassword) {
            JsonResponse::error('Passwords do not match', 422);
            return;
        }

        $hashedPassword = $this->hashPassword($password);
        $user = new User(null, $email, $hashedPassword);

        $this->userRepository->createUser($user);

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_email'] = $user->getEmail();

        JsonResponse::success(['message' => 'Registration successful'], 201);
    }

    public function logoutUser(): void
    {
        $_SESSION = [];
        session_destroy();

        header('Content-Type: application/json');
        JsonResponse::success(['message' => 'Logout successful'], 202);
    }
}