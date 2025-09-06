<?php

namespace Bahraz\ToDoApp\Repositories;

use Bahraz\ToDoApp\Core\Database;
use Bahraz\ToDoApp\Entities\Task;

class TaskRepository implements TaskRepositoryInterface{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function addTask(array $taskData): bool
    {
        $this->db->query(
            "INSERT INTO tasks (user_id, title, completed, priority, date, deleted) 
             VALUES (:user_id, :title, :completed, :priority, :date, :deleted)",
            [
                ':user_id' => $taskData['user_id'],
                ':title' => $taskData['title'],
                ':completed' => $taskData['completed'],
                ':priority' => $taskData['priority'],
                ':date' => $taskData['date'],
                ':deleted' => $taskData['deleted']
            ]
        );

        return $this->db->lastInsertId() > 0;
    }

    public function updateTask(int $taskId, array $taskData): bool
    {
        $stmt = $this->db->query(
            "UPDATE tasks SET title = :title, completed = :completed, priority = :priority, date = :date, deleted = :deleted 
             WHERE id = :id",
            [
                ':id' => $taskId,
                ':title' => $taskData['title'],
                ':completed' => $taskData['completed'],
                ':priority' => $taskData['priority'],
                ':date' => $taskData['date'],
                ':deleted' => $taskData['deleted']
            ]
        );

        return $stmt->rowCount() > 0;
    }

}