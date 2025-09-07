<?php

namespace Bahraz\ToDoApp\Controllers\Api;

use Bahraz\ToDoApp\Repositories\TaskRepository;
use Bahraz\ToDoApp\Core\Database;
use Bahraz\ToDoApp\Entities\Task;

class TaskController
{
    private TaskRepository $taskRepository;

    public function __construct()
    {
        $db = new Database();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->taskRepository = new TaskRepository($db, $_SESSION['user_id'] ?? 0);
    }

    public function addTask(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $csrfToken = $_POST['csrf_token'] ?? '';

        if (!\Bahraz\ToDoApp\Core\Csrf::validateCsrf($csrfToken)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid CSRF token']);
            return;
        }

        $userId = $_SESSION['user_id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $priority = $_POST['priority'] ?? 'normal';
        $date = $_POST['date'] ?? date('Y-m-d');

        if (empty($title)) {
            http_response_code(400);
            echo json_encode(['error' => 'Title is required']);
            return;
        }

        $task = new Task(
            id: null,
            userId: $userId,
            title: $title,
            completed: false,
            priority: $priority,
            date: $date,
            deleted: false
        );

        $success = $this->taskRepository->addTask($task);

        if ($success) {
            http_response_code(201);
            echo json_encode(['message' => 'Task added successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add task']);
        }
    }

    public function updateTask(int $id): void
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!\Bahraz\ToDoApp\Core\Csrf::validateCsrf($csrfToken)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid CSRF token']);
            return;
        }


        if (!is_array($input)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            return;
        }

        $userId = $_SESSION['user_id'] ?? 0;

        $existingTask = $this->taskRepository->getTaskById($id);
        if (!$existingTask) {
            http_response_code(404);
            echo json_encode(['error' => 'Task not found']);
            return;
        }

        if (isset($input['title'])) {
            $existingTask->setTitle($input['title']);
        }
        if (isset($input['completed'])) {
            $existingTask->setCompleted((bool)$input['completed']);
        }
        if (isset($input['priority'])) {
            $existingTask->setPriority($input['priority']);
        }
        if (isset($input['date'])) {
            $existingTask->setDate($input['date']);
        }
        if (isset($input['deleted'])) {
            $existingTask->setDeleted((bool)$input['deleted']);
        }

        if ($this->taskRepository->updateTask($id, $existingTask)) {
            http_response_code(200);
            echo json_encode(['message' => 'Task updated']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update task']);
        }
    }
}
