<?php

namespace Bahraz\ToDoApp\Repositories;

use Bahraz\ToDoApp\Entities\Task;

interface TaskRepositoryInterface {
    public function getTaskById(int $taskId): ?Task;
    public function addTask(Task $taskData): bool;
    public function updateTask(int $taskId, Task $taskData): bool;

    public function getAllNotDeletedTasks(): array;
    public function getActiveTasks(): array;
    public function getTodayTasks(): array;
    public function getCompletedTasks(): array;
    public function getDeletedTasks(): array;
}