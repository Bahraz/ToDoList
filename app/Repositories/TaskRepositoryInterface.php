<?php

namespace Bahraz\ToDoApp\Repositories;

interface TaskRepositoryInterface {
    public function addTask(array $taskData): bool;
    public function updateTask(int $taskId, array $taskData): bool;
}