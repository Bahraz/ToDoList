<?php
namespace Bahraz\ToDoApp\Controllers\Web;

use Bahraz\ToDoApp\Models\Task;
use Bahraz\ToDoApp\Models\TaskModel;
use Bahraz\ToDoApp\Controllers\BaseController;

class ApiController extends BaseController
{
    
    //TODO: At this moment, sesion is not used in the project, but it might be useful in the future.
    // private function startSession(): void
    // {
    //     if (session_status() === PHP_SESSION_NONE) {
    //         session_start();
    //     }
    // }

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