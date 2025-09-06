<?php

namespace Bahraz\ToDoApp\Repositories;

use Bahraz\ToDoApp\Entities\User;

interface UserRepositoryInterface {
    public function findUserByEmail(string $email): ?User;
    public function createUser(string $email, string $password): bool;
}