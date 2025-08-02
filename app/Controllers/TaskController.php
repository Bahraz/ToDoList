<?php

namespace Bahraz\ToDoApp\Controllers;

use Bahraz\ToDoApp\Models\TaskModel;

class TaskController{

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
        $success = TaskModel::addTask([
            'title' => $title,
            'priority' => $priority,
            'date' => $date,
            'completed' => 0,
        ]);

        if ($success) {
            http_response_code(201);
            echo json_encode(['message' => 'Task added successfully'], JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add task']);
        }
    }

    public function updateTask(string $action, int $id): void
    {
        header('Content-Type: application/json');

        if (!in_array($action, ['complete', 'uncomplete', 'delete'], true)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid action']);
            return;
        }

        $success = false;

        if ($action === 'delete') {
            $success = TaskModel::deleteTask($id);
        } elseif ($action === 'complete') {
            $success = TaskModel::updateTask($id, true);
        } elseif ($action === 'uncomplete') {
            $success = TaskModel::updateTask($id, false);
        }

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'Task updated']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update task']);
        }
    }
}
