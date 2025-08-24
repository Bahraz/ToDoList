<?php
namespace Bahraz\ToDoApp\Controllers\Web;

use Bahraz\ToDoApp\Models\TaskModel;
use Bahraz\ToDoApp\Controllers\BaseController;

class ApiController extends BaseController
{
    public function index(): void
    {
        header('Content-Type: application/json');

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