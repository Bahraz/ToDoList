<?php

namespace Bahraz\ToDoApp\Controllers\Api;

use Bahraz\ToDoApp\Repositories\UserRepository;
use Bahraz\ToDoApp\Core\Database;
use Bahraz\ToDoApp\Entities\User;




use Bahraz\ToDoApp\Models\UserModel;
class UserController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    private function verifyPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

public function loginUser() {
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);
    $email = strtolower($input['email'] ?? '');
    $password = $input['password'] ?? '';

    $db = new Database();
    $userRepository = new UserRepository($db);

    $user = $userRepository->findUserByEmail($email);

    if ($user && $this->verifyPassword($password, $user->getPassword())) {
        session_start();
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_email'] = $user->getEmail();

        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    }
}

public function registerUser()
{
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);
    $email = strtolower($input['email'] ?? '');
    $password = $input['password'] ?? '';
    $confirmPassword = $input['confirmPassword'] ?? '';

    $db = new Database();
    $userRepository = new UserRepository($db);


    if ($userRepository->findUserByEmail($email)) {
        echo json_encode(['success' => false, 'message' => 'Email already in use']);
        return;
    }


    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
        return;
    }


    $hashedPassword = $this->hashPassword($password);
    $user = new User(null, $email, $hashedPassword);


    $userRepository->createUser($user);

    session_start();
    $_SESSION['user_id'] = $user->getId();
    $_SESSION['user_email'] = $user->getEmail();

    echo json_encode(['success' => true, 'message' => 'Registration successful']);
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