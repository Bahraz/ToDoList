<?php

namespace Bahraz\ToDoApp\Controllers\Api;

use Bahraz\ToDoApp\Repositories\UserRepository;
use Bahraz\ToDoApp\Core\Database;
use Bahraz\ToDoApp\Core\Csrf;
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

        if (!\Bahraz\ToDoApp\Core\Csrf::validateCsrf($input['csrf_token'] ?? '')) {
            echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
            return;
        }

        $email = strtolower($input['email'] ?? '');
        $password = $input['password'] ?? '';
        
        $user = $this->userRepository->findUserByEmail($email);
        
        if ($user && $this->verifyPassword($password, $user->getPassword())) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_email'] = $user->getEmail();
            
            echo json_encode(['success' => true, 'message' => 'Login successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        }
    }

    public function registerUser(): void
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);
        $email = strtolower($input['email'] ?? '');
        $password = $input['password'] ?? '';
        $confirmPassword = $input['confirmPassword'] ?? '';

        if ($this->userRepository->findUserByEmail($email)) {
            echo json_encode(['success' => false, 'message' => 'Email already in use']);
            return;
        }

        if ($password !== $confirmPassword) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
            return;
        }

        $hashedPassword = $this->hashPassword($password);
        $user = new User(null, $email, $hashedPassword);

        $this->userRepository->createUser($user);

        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_email'] = $user->getEmail();

        echo json_encode(['success' => true, 'message' => 'Registration successful']);
    }

    public function logoutUser(): void
    {
        $_SESSION = [];
        session_destroy();

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Logout successful']);
    }
}
