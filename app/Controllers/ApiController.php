<?php
namespace Bahraz\ToDoApp\Controllers;

use Bahraz\ToDoApp\Models\Task;

class ApiController
{
    public function index(): void
    {
        header('Content-Type: application/json');
        session_start();

        $tasks = array_filter(Task::getAll(), fn($task) => !$task['deleted']);
        echo json_encode(array_values($tasks), JSON_PRETTY_PRINT);
    }
}
