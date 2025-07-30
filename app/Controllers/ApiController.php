<?php
namespace Bahraz\ToDoApp\Controllers;

use Bahraz\ToDoApp\Models\Task;

class ApiController
{

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index(): void
    {
        header('Content-Type: application/json');
        $this->startSession();

        $status = $_GET['status'] ?? 'all';

        $tasks = Task::getAll();

        switch ($status) {
            case 'all':
                $tasks = array_filter($tasks, fn($task) => !$task['deleted']);
            case 'active':
                $tasks = array_filter($tasks, fn($task) => !$task['completed'] && !$task['deleted']);
                break;
            case 'today':
                $today = date('Y-m-d');
                $tasks = array_filter($tasks, fn($task) => !$task['completed'] && $task['date'] === $today && !$task['deleted']);
                break;
            case 'completed':
                $tasks = array_filter($tasks, fn($task) => $task['completed'] && !$task['deleted']);
                break;
            case 'deleted':
                $tasks = array_filter($tasks, fn($task) => $task['deleted']);
                break;
            }
        echo json_encode(array_values($tasks), JSON_PRETTY_PRINT);
    }

    public function addTask(): void
    {
        header('Content-Type: application/json');
        $this->startSession();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }
        
        $title = $_POST['title'] ?? '';
        $priority = $_POST['priority'] ?? 'normal';
        $date = $_POST['date'] ?? date('Y-m-d');

        if (empty($title)) {
                http_response_code(400);
                echo json_encode(['error' => 'Title is required']);
                return;
            }

            $tasks= $_SESSION['tasks'] ?? Task::getAll();

            $maxID = !empty($tasks)? max(array_column($tasks,'id')):0;
            
            $newTask = [
                'id' => $maxID + 1,
                'title' => $title,
                'completed' => false,
                'priority' => $priority,
                'date' => $date,
                'deleted' => false,
            ];

            $tasks[] = $newTask;
            $_SESSION['tasks'] = $tasks;

            http_response_code(201);
            echo json_encode([
                'message' => 'Task added successfully',
                'task' => $newTask
            ], JSON_PRETTY_PRINT);
    }

    public function completeTask($id): void
    {
        header('Content-Type: application/json');
        $this->startSession();

        $id = (int)$id;

        if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $tasks = $_SESSION['tasks'] ?? Task::getAll();
        $found = false;

        foreach ($tasks as &$task) {
            if ($task['id'] === $id) {
                if ($task['completed']) {
                    http_response_code(409);
                    echo json_encode(['message' => 'Task is already completed.']);
                    return;
                }
                $task['completed'] = true;
                $found = true;
                break;
            }
        }

        if ($found) {
            $_SESSION['tasks'] = $tasks;
            http_response_code(200);
            echo json_encode(['message' => 'Task completed successfully', 'task' => $task], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Task not found']);
        }
    }
    

    public function unCompleteTask($id): void
    {
        header('Content-Type: application/json');
        $this->startSession();

        $id = (int)$id;

        if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $tasks = $_SESSION['tasks'] ?? Task::getAll();
        $found = false;

        foreach ($tasks as &$task) {
            if ($task['id'] === $id) {
                if (!$task['completed']) {
                    http_response_code(409);
                    echo json_encode(['error' => 'Task is not completed']);
                    return;
                }
                $task['completed'] = false;
                $found = true;
                break;
            }
        }

        if ($found) {
            $_SESSION['tasks'] = $tasks;
            http_response_code(200);
            echo json_encode(['message' => 'Task marked as uncompleted successfully', 'task' => $task], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Task not found']);
        }
    }

    public function deleteTask($id): void
    {
        header('Content-Type: application/json');
        $this->startSession();

        $id = (int)$id;

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $tasks = $_SESSION['tasks'] ?? Task::getAll();
        $found = false;

        foreach ($tasks as &$task) {
            if ($task['id'] === $id) {
                if ($task['deleted']) {
                    http_response_code(409);
                    echo json_encode(['error' => 'Task already deleted']);
                    return;
                }
                $task['deleted'] = true;
                $found = true;
                break;
            }
        }

        if ($found) {
            $_SESSION['tasks'] = $tasks;
            http_response_code(200);
            echo json_encode(['message' => 'Task deleted successfully', 'task' => $task], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Task not found']);
        }
    }
}