<?php

namespace Bahraz\ToDoApp\Controllers\Api;

use Bahraz\ToDoApp\Models\TaskModel;
class TaskController
{
    private TaskModel $taskModel;

    public function __construct()
    {
        $this->taskModel = new TaskModel();
    }

    // public function index(): void
    // {
    //     header('Content-Type: application/json');

    //     $status = $_GET['status'] ?? 'all';

    //     switch ($status) {
    //         case 'all':
    //             $tasks = $this->taskModel->getAllNotDeletedTasks();
    //             break;
    //         case 'active':
    //             $tasks = $this->taskModel->getActiveTasks();
    //             break;
    //         case 'today':
    //             $tasks = $this->taskModel->getTodayTasks();
    //             break;
    //         case 'completed':
    //             $tasks = $this->taskModel->getCompletedTasks();
    //             break;
    //         case 'deleted':
    //             $tasks = $this->taskModel->getDeletedTasks();
    //             break;
    //         default:
    //             http_response_code(400);
    //             echo json_encode(['error' => 'Invalid status']);
    //             return;
    //     }

    //     echo json_encode(array_values($tasks));
    // }

    public function addTask(): void
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $title = $_POST['title'] ?? '';
        $priority = $_POST['priority'] ?? 'normal';
        $date = $_POST['date'] ?? date('Y-m-d');

        if (empty($title)) {
            http_response_code(400);
            echo json_encode(['error' => 'Title is required']);
            return;
        }

        $success = $this->taskModel->addTask([
            'title' => $title,
            'priority' => $priority,
            'date' => $date,
            'completed' => 0,
        ]);

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
        $input = json_decode(file_get_contents('php://input'), true);

        if (!is_array($input)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON']);
            return;
        }

        $fieldsToUpdate = [];

        foreach (['title', 'completed', 'priority', 'date', 'deleted'] as $field) {
            if (isset($input[$field])) {
                $fieldsToUpdate[$field] = ($field === 'completed' || $field === 'deleted')
                    ? (int)$input[$field]
                    : $input[$field];
            }
        }

        if (empty($fieldsToUpdate)) {
            http_response_code(400);
            echo json_encode(['error' => 'No valid fields provided']);
            return;
        }

        if ($this->taskModel->updateTaskById($id, $fieldsToUpdate)) {
            http_response_code(200);
            echo json_encode(['message' => 'Task updated']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update task']);
        }
    }
}
