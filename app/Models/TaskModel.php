<?php

namespace Bahraz\ToDoApp\Models;

use Bahraz\ToDoApp\Core\Database;

class TaskModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    protected function getUserID(): int
    {
        session_start();
        return $_SESSION['user_id'] ?? 0;
    }

    public function getTodayTasks(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM tasks WHERE date = :date AND deleted = 0 AND user_id = :user_id", 
            [':date' => date('Y-m-d'), ':user_id' => $this->getUserID()]) ?? [];
    }

    public function getActiveTasks(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM tasks WHERE completed = 0 AND deleted = 0 AND user_id = :user_id ORDER BY date DESC", 
            [':user_id' => $this->getUserID()]) ?? [];
    }

    public function getCompletedTasks(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM tasks WHERE completed = 1 AND deleted = 0 AND user_id = :user_id",
            [':user_id' => $this->getUserID()]) ?? [];
    }

    public function getAllNotDeletedTasks(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM tasks WHERE deleted = 0 AND user_id = :user_id",
            [':user_id' => $this->getUserID()]) ?? [];
    }

    public function getDeletedTasks(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM tasks WHERE deleted = 1 AND user_id = :user_id",
            [':user_id' => $this->getUserID()]) ?? [];
    }

    public function getAllTasks(): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM tasks WHERE user_id = :user_id ORDER BY date DESC",
            [':user_id' => $this->getUserID()]) ?? [];
    }

    public function getById(int $id): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM tasks WHERE id = :id AND user_id = :user_id",
            [':id' => $id, ':user_id' => $this->getUserID()]
        ) ?? [];
    }

    public function addTask(array $data): \PDOStatement|false
    {
        return $this->db->query(
            "INSERT INTO tasks (user_id, title, completed, priority, date, deleted) 
             VALUES (:user_id, :title, :completed, :priority, :date, :deleted)",
            [
                ':user_id' => $this->getUserID(),
                ':title' => $data['title'],
                ':completed' => $data['completed'] ?? 0,
                ':priority' => $data['priority'] ?? 'normal',
                ':date' => $data['date'] ?? date('Y-m-d'),
                ':deleted' => 0
            ]
        );
    }

    public function updateTaskById(int $id, array $fields): \PDOStatement|false
    {
        $allowedFields = ['title', 'completed', 'priority', 'date', 'deleted'];
        $setParts = [];
        $params = [':id' => $id, ':user_id' => $this->getUserID()];

        foreach ($fields as $key => $value) {
            if (in_array($key, $allowedFields, true)) {
                $paramKey = ':' . $key;

                if (in_array($key, ['completed', 'deleted'], true)) {
                    $value = (int) $value;
                }

                $setParts[] = "$key = $paramKey";
                $params[$paramKey] = $value;
            }
        }

        $sql = "UPDATE tasks SET " . implode(', ', $setParts) . " WHERE id = :id AND user_id = :user_id";
        return $this->db->query($sql, $params);
    }

    public function deleteTask(int $id): \PDOStatement|false
    {
        return $this->db->query(
            "UPDATE tasks SET deleted = 1 WHERE id = :id AND user_id = :user_id",
            [':id' => $id, ':user_id' => $this->getUserID()]
        );
    }
}