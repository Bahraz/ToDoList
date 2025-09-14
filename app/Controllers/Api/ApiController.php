<?php

namespace Bahraz\ToDoApp\Controllers\Api;

use Bahraz\ToDoApp\Core\Database;
use Bahraz\ToDoApp\Core\JsonResponse;
use Bahraz\ToDoApp\Repositories\TaskRepository;

class ApiController
{
    private TaskRepository $taskRepository;
    private int $userId;
    
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->userId = $_SESSION['user_id'] ?? 0;

        if (!$this->userId) {
            JsonResponse::error('Unauthorized', 401);
        }
        $db = new Database();
        $this->taskRepository = new TaskRepository($db, $this->userId);
    }

    public function index(): void
    {

        $status = $_GET['status'] ?? 'all';

        switch ($status) {
            case 'all':
                $tasks = $this->taskRepository->getAllNotDeletedTasks();
                break;
            case 'active':
                $tasks = $this->taskRepository->getActiveTasks();
                break;
            case 'today':
                $tasks = $this->taskRepository->getTodayTasks();
                break;
            case 'completed':
                $tasks = $this->taskRepository->getCompletedTasks();
                break;
            case 'deleted':
                $tasks = $this->taskRepository->getDeletedTasks();
                break;
            default:
                JsonResponse::error('Invalid status', 400);
                return;
        }

        echo json_encode(array_map(fn($task) => [
            'id' => $task->getId(),
            'user_id' => $task->getUserId(),
            'title' => $task->getTitle(),
            'completed' => $task->getCompleted(),
            'priority' => $task->getPriority(),
            'date' => $task->getDate(),
            'deleted' => $task->getDeleted()
        ], $tasks));
    }
}
