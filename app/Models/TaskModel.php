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
        
        $stmt = $pdo->query("SELECT * FROM tasks WHERE completed=0 AND deleted=0 ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }        
    }

    public static function getCompletedTasks(): array
    {

        try {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->query("SELECT * FROM tasks WHERE completed=1 AND deleted=0 ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }        
    }

        public static function getAllNotDeletedTasks(): array
    {

        try {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->query("SELECT * FROM tasks WHERE deleted=0 ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }        
    }

    public static function getDeletedTasks():array
    {

        try {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->query("SELECT * FROM tasks WHERE deleted=1 ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }        
    }

    public static function getAllTasks(): array
    {

        try {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->query("SELECT * FROM tasks ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }        
    }

    //TODO: maybe delete this function? idk
    public static function getById(int $id): ?array
    {

        try {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id AND deleted = 0");
        $stmt->execute([':id' => $id]);

        $task=$stmt->fetch(PDO::FETCH_ASSOC);

        return $task ?: null;
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }        
    }

    public static function addTask(array $data)
    {

        try {
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
        } catch (PDOException $e) {
            throw new RuntimeException('Database query failed: ' . $e->getMessage());
        }        
    }
    public static function updateTask(int $id, int $completed): bool
    {

        try {
        $pdo = Database::getConnection();

        $sql = "UPDATE tasks SET completed = :completed WHERE id = :id AND deleted = 0";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':completed' => $completed ? 1 : 0,]);
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
