<?php
namespace Bahraz\ToDoApp\Controllers\Api;

use Bahraz\ToDoApp\Models\TaskModel;
// use Bahraz\ToDoApp\Controllers\BaseController
use Bahraz\ToDoApp\Controllers\Api\TaskController;

class ApiController extends TaskController
{
    private TaskModel $taskModel;

    public function __construct()
    {
        $this->taskModel = new TaskModel();
    }

    public function index(): void
    {
        header('Content-Type: application/json');

        $status = $_GET['status'] ?? 'all';

        switch ($status) {
            case 'all':
                $tasks = $this->taskModel->getAllNotDeletedTasks();
                break;
            case 'active':
                $tasks = $this->taskModel->getActiveTasks();
                break;
            case 'today':
                $tasks = $this->taskModel->getTodayTasks();
                break;
            case 'completed':
                $tasks = $this->taskModel->getCompletedTasks();
                break;
            case 'deleted':
                $tasks = $this->taskModel->getDeletedTasks();
                break;
            default:
                http_response_code(400);
                echo json_encode(['error' => 'Invalid status']);
                return;
        }

        echo json_encode(array_values($tasks));
    }
}