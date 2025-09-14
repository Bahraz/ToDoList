<?php

namespace Bahraz\ToDoApp\Controllers\Api;

use Bahraz\ToDoApp\Core\Database;
use Bahraz\ToDoApp\Core\TokenCsrf;
use Bahraz\ToDoApp\Core\JsonResponse;
use Bahraz\ToDoApp\Entities\Task;
use Bahraz\ToDoApp\Repositories\TaskRepository;

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
            JsonResponse::error('Method Not Allowed', 405);
            return;
        }

        $csrfToken = $_POST['TokenCsrf'] ?? '';

        if (!TokenCsrf::verifyCsrf($csrfToken)) {
            JsonResponse::error('Invalid CSRF token.', 403);
            return;
        }

        $userId = $_SESSION['user_id'] ?? 0;
        $title = $_POST['title'] ?? '';
        $priority = $_POST['priority'] ?? 'normal';
        $date = $_POST['date'] ?? date('Y-m-d');

        if (empty($title)) {
            JsonResponse::error('Title is required.', 422);
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
            JsonResponse::success(['message' => 'Task added successfully'], 201);
        } else {
            JsonResponse::error('Failed to add task', 500);
        }
    }

    public function updateTask(int $id): void
    {
        header('Content-Type: application/json');

        $input = json_decode(file_get_contents('php://input'), true);

        $csrfToken = $_SERVER['HTTP_X_TokenCsrf'] ?? '';
        if (!TokenCsrf::verifyCsrf($csrfToken)) {
            JsonResponse::error('Invalid CSRF token.', 403);
            return;
        }


        if (!is_array($input)) {
            JsonResponse::error('Invalid JSON', 400);
            return;
        }

        $userId = $_SESSION['user_id'] ?? 0;

        $existingTask = $this->taskRepository->getTaskById($id);
        if (!$existingTask) {
            JsonResponse::error('Task not found', 404);
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
            JsonResponse::success(['message' => 'Task updated successfully'], 200);
        } else {
            JsonResponse::error('Failed to update task', 500);
        }
    }
}
