<?php

namespace Bahraz\ToDoApp\Models;

use Bahraz\ToDoApp\Core\Database;
use PDO;
use PDOException;

class TaskModel
{

    public static function getTodayTasks(): array{
        $pdo = Database::getConnection();
        $today = date('Y-m-d');

        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE date = :date AND deleted = 0");
        $stmt->execute([':date' => $today]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getActiveTasks(): array
    {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->query("SELECT * FROM tasks WHERE completed=0 AND deleted=0 ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCompletedTasks(): array
    {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->query("SELECT * FROM tasks WHERE completed=1 AND deleted=0 ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public static function getAllNotDeletedTasks(): array
    {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->query("SELECT * FROM tasks WHERE deleted=0 ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDeletedTasks():array{
        $pdo = Database::getConnection();
        
        $stmt = $pdo->query("SELECT * FROM tasks WHERE deleted=1 ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllTasks(): array
    {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->query("SELECT * FROM tasks ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //TODO: maybe delete this function? idk
    public static function getById(int $id): ?array
    {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id AND deleted = 0");
        $stmt->execute([':id' => $id]);

        $task=$stmt->fetch(PDO::FETCH_ASSOC);

        return $task ?: null;
    }

    public static function addTask(array $data)
    {
        $pdo = Database::getConnection();

        $sql = "INSERT INTO tasks (title, completed, priority, date, deleted) VALUES (:title, :completed, :priority, :date, :deleted)";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':title' => $data['title'],
            ':completed' => $data['completed'] ?? 0,
            ':priority' => $data['priority'] ?? 'normal',
            ':date' => date('Y-m-d'),
            ':deleted' => 0
        ]);
    }

    public static function updateTask(int $id, bool $completed): bool
    {
        $pdo = Database::getConnection();

        $sql = "UPDATE tasks SET completed = :completed WHERE id = :id AND deleted = 0";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':completed' => $completed ? 1 : 0,
        ]);
    }

    public static function deleteTask(int $id): bool
    {
        $pdo = Database::getConnection();

        $sql = "UPDATE tasks SET deleted = 1 WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}


