<?php

namespace Bahraz\ToDoApp\Controllers\Api;

use Bahraz\ToDoApp\Models\UserModel;

class UserController {
    public function loginUser() {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        $email = strtolower($input['email'] ?? '');
        $password = $input['password'] ?? '';
        

        $user = UserModel::findUserByEmail($email);

        if ($user && UserModel::verifyUserPassword($password, $user['password'])) {
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

        if (UserModel::findUserByEmail($email)) {
            echo json_encode(['success' => false, 'message' => 'Email already in use']);
            return;
        }

        if ($password !== $confirmPassword) {
            echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
            return;
        }

        $hashedPassword = UserModel::hashPassword($password);
        
        $userId = UserModel::createUser($email, $hashedPassword);

        if ($userId) {
            echo json_encode(['success' => true, 'message' => 'Registration successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Registration failed']);
        }
    }

    public function logoutUser() {
        session_start();
        session_destroy();

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Logout successful']);
    }
}