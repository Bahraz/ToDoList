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
        session_start();

        $tasks = array_filter(Task::getAll(), fn($task) => !$task['deleted']);
        echo json_encode(array_values($tasks), JSON_PRETTY_PRINT);
    }

    public function addTask(): void
    {
        header('Content-Type: application/json');
        $this->startSession();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = $_POST['title'] ?? '';
            $priority = $_POST['priority'] ?? 'normal';
            $date = $_POST['date'] ?? date('Y-m-d');

            $tasks= $_SESSION['tasks'] ?? Task::getAll();

            $maxID = max(array_column($tasks, 'id')) ?? 0;

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

            echo json_encode(['message' => 'Task added successfully', 'task' => $newTask], JSON_PRETTY_PRINT);

        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }
    }
}

