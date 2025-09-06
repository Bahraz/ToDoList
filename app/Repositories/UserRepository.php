<?php 

namespace Bahraz\ToDoApp\Repositories;

use Bahraz\ToDoApp\Core\Database;
use Bahraz\ToDoApp\Entities\User;

class UserRepository implements UserRepositoryInterface{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function findUserByEmail(string $email): ?User
    {
        $result = $this->db->fetch(
            "SELECT * FROM users WHERE email = :email",
            [':email' => $email]
        );

        if ($result) {
            return new User($result['id'], $result['email'], $result['password']);
        }

        return null;
    }
        
    public function createUser(User $user): void 
{
    $this->db->query(
        "INSERT INTO users (email, password) VALUES (:email, :password)",
        [
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword()
        ]
    );

    $user->setId((int)$this->db->lastInsertId());
}

}