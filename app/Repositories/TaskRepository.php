<?php

namespace Bahraz\ToDoApp\Repositories;

use Bahraz\ToDoApp\Core\Database;
use Bahraz\ToDoApp\Entities\Task;

class TaskRepository
{
    private Database $db;
    private int $userId;

    public function __construct(Database $db, int $userId)
    {
        $this->db = $db;
        $this->userId = $userId;
    }

    public function getTaskById(int $taskId): ?Task
    {
        $sql = "SELECT * FROM tasks WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->query($sql, [':id' => $taskId, ':user_id' => $this->userId]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            return new Task(
                $data['id'],
                $data['user_id'],
                $data['title'],
                (bool)$data['completed'],
                $data['priority'],
                $data['date'],
                (bool)$data['deleted']
            );
        }

        return null;
    }

    public function addTask(Task $task): bool
    {
        $sql = "INSERT INTO tasks (user_id, title, completed, priority, date, deleted) 
                VALUES (:user_id, :title, :completed, :priority, :date, :deleted)";

        $this->db->query($sql, [
            ':user_id'   => $task->getUserId(),
            ':title'     => $task->getTitle(),
            ':completed' => (int)$task->getCompleted(),
            ':priority'  => $task->getPriority(),
            ':date'      => $task->getDate(),
            ':deleted'   => (int)$task->getDeleted()
        ]);

        return (int)$this->db->lastInsertId() > 0;
    }

    public function updateTask(int $taskId, Task $task): bool
    {
        $sql = "UPDATE tasks SET title = :title, completed = :completed, priority = :priority, date = :date, deleted = :deleted
                WHERE id = :id AND user_id = :user_id";

        $stmt = $this->db->query($sql, [
            ':id'        => $taskId,
            ':user_id'   => $this->userId,
            ':title'     => $task->getTitle(),
            ':completed' => (int)$task->getCompleted(),
            ':priority'  => $task->getPriority(),
            ':date'      => $task->getDate(),
            ':deleted'   => (int)$task->getDeleted()
        ]);

        return $stmt->rowCount() > 0;
    }

    private function fetchTasks(string $sql, array $params = []): array
    {
        $stmt = $this->db->query($sql, $params);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return array_map(fn($data) => new Task(
            $data['id'],
            $data['user_id'],
            $data['title'],
            (bool)$data['completed'],
            $data['priority'],
            $data['date'],
            (bool)$data['deleted']
        ), $rows);
    }

    public function getAllNotDeletedTasks(): array
    {
        return $this->fetchTasks(
            "SELECT * FROM tasks WHERE deleted = 0 AND user_id = :user_id",
            [':user_id' => $this->userId]
        );
    }

    public function getActiveTasks(): array
    {
        return $this->fetchTasks(
            "SELECT * FROM tasks WHERE completed = 0 AND deleted = 0 AND user_id = :user_id ORDER BY date DESC",
            [':user_id' => $this->userId]
        );
    }

    public function getCompletedTasks(): array
    {
        return $this->fetchTasks(
            "SELECT * FROM tasks WHERE completed = 1 AND deleted = 0 AND user_id = :user_id",
            [':user_id' => $this->userId]
        );
    }

    public function getDeletedTasks(): array
    {
        return $this->fetchTasks(
            "SELECT * FROM tasks WHERE deleted = 1 AND user_id = :user_id",
            [':user_id' => $this->userId]
        );
    }

    public function getTodayTasks(): array
    {
        return $this->fetchTasks(
            "SELECT * FROM tasks WHERE date = :date AND deleted = 0 AND user_id = :user_id",
            [':date' => date('Y-m-d'), ':user_id' => $this->userId]
        );
    }
}
