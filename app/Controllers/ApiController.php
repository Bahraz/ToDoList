<?php
namespace Bahraz\ToDoApp\Controllers;

use Bahraz\ToDoApp\Models\Task;
use Bahraz\ToDoApp\Models\TaskModel;

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
            }
        echo json_encode(array_values($tasks), JSON_PRETTY_PRINT);
    }
}