<?php

namespace Bahraz\ToDoApp\Models;

use Bahraz\ToDoApp\Core\Database;
use PDO;
use PDOException;
use RuntimeException;

class TaskModel
{
    public static function getTodayTasks(): array
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE date = :date AND deleted = 0");
            $stmt->execute([':date' => date('Y-m-d')]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }
    }

    public static function getActiveTasks(): array
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE completed = 0 AND deleted = 0 ORDER BY date DESC");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }
    }

    public static function getCompletedTasks(): array
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE completed = 1 AND deleted = 0 ORDER BY date DESC");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }
    }

    public static function getAllNotDeletedTasks(): array
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE deleted = 0 ORDER BY date DESC");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }
    }

    public static function getDeletedTasks(): array
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE deleted = 1 ORDER BY date DESC");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }
    }

    public static function getAllTasks(): array
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM tasks ORDER BY date DESC");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }
    }

    public static function getById(int $id): ?array
    {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id AND deleted = 0");
            $stmt->execute([':id' => $id]);

            $task = $stmt->fetch(PDO::FETCH_ASSOC);

            return $task ?: null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }
    }

    public static function addTask(array $data): bool
    {
        try {
            $pdo = Database::getConnection();

            $sql = "INSERT INTO tasks (title, completed, priority, date, deleted) 
                    VALUES (:title, :completed, :priority, :date, :deleted)";
            $stmt = $pdo->prepare($sql);

            return $stmt->execute([
                ':title' => $data['title'],
                ':completed' => $data['completed'] ?? 0,
                ':priority' => $data['priority'] ?? 'normal',
                ':date' => $data['date'] ?? date('Y-m-d'),
                ':deleted' => 0
            ]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }
    }

    /**
     * Update specific fields of a task by id.
     * Example usage: updateTaskById(5, ['completed' => 1, 'priority' => 'high']);
     */
    public static function updateTaskById(int $id, array $fields): bool
{
    try {
        $pdo = Database::getConnection();

        $allowedFields = ['title', 'completed', 'priority', 'date', 'deleted'];
        $setParts = [];
        $params = [':id' => $id];

        foreach ($fields as $key => $value) {
            if (in_array($key, $allowedFields, true)) {
                $paramKey = ':' . $key;

                // Zamień boolean na int w polach logicznych
                if (in_array($key, ['completed', 'deleted'], true)) {
                    $value = (int) $value;
                }

                $setParts[] = "$key = $paramKey";
                $params[$paramKey] = $value;
            }
        }

        if (empty($setParts)) {
            return false; // Nic do aktualizacji
        }

        $sql = "UPDATE tasks SET " . implode(', ', $setParts) . " WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        if (!$stmt->execute($params)) {
            error_log(print_r($stmt->errorInfo(), true)); // log SQL błędów
            return false;
        }

        return true;

    } catch (PDOException $e) {
        throw new RuntimeException('Database query failed: ' . $e->getMessage());
    }
}


    public static function deleteTask(int $id): bool
    {
        try {
            $pdo = Database::getConnection();
            $sql = "UPDATE tasks SET deleted = 1 WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }
    }
}
