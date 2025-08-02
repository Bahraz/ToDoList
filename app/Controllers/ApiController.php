<?php
namespace Bahraz\ToDoApp\Controllers;

use Bahraz\ToDoApp\Models\Task;
use Bahraz\ToDoApp\Models\TaskModel;

class ApiController
{
    
    //TODO: At this moment, sesion is not used in the project, but it might be useful in the future.
    // private function startSession(): void
    // {
    //     if (session_status() === PHP_SESSION_NONE) {
    //         session_start();
    //     }
    // }

    private function respond($data, int $statusCode = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function index(): void
    {
        header('Content-Type: application/json');

        // $this->startSession();

        $status = $_GET['status'] ?? 'all';

        switch ($status) {
            case 'all':
                $tasks = TaskModel::getAllNotDeletedTasks();
                break;
            case 'active':
                $tasks = TaskModel::getActiveTasks();
                break;
            case 'today':
                $tasks = TaskModel::getTodayTasks();
                break;
            case 'completed':
                $tasks = TaskModel::getCompletedTasks();
                break;
            case 'deleted':
                $tasks = TaskModel::getDeletedTasks();
                break;
            default:
                $this->respond(['error' => 'Invalid status'], 400);
                return;
            }
        $this->respond(array_values($tasks));
    }
}