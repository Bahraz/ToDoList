<?php

namespace Bahraz\ToDoApp\Controllers\Api;

use Bahraz\ToDoApp\Models\UserModel;
class UserController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function loginUser() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        $email = strtolower($input['email'] ?? '');
        $password = $input['password'] ?? '';

        $user = $this->userModel->findUserByEmail($email);

        if ($user && $this->userModel->verifyUserPassword($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            echo json_encode(['success' => true, 'message' => 'Login successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        }
    }


    public function registerUser() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        $email = strtolower($input['email'] ?? '');
        $password = $input['password'] ?? '';
        $confirmPassword = $input['confirmPassword'] ?? '';

        if ($this->userModel->findUserByEmail($email)) {
            echo json_encode(['success' => false, 'message' => 'Email already in use']);
            return;
        }

        if ($password !== $confirmPassword) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
            return;
        }

        $hashedPassword = $this->userModel->hashPassword($password);

        $userId = $this->userModel->createUser($email, $hashedPassword);

        if ($userId) {
            session_start();

            $user = $this->userModel->findUserByEmail($email);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            echo json_encode(['success' => true, 'message' => 'Registration successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Registration failed']);
        }
    }

        public function logoutUser() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        
        session_destroy();

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Logout successful']);
    }
}