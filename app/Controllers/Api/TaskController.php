<?php
namespace Bahraz\ToDoApp\Controllers\Api;

use Bahraz\ToDoApp\Models\TaskModel;

class TaskController {

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
                http_response_code(400);
                echo json_encode(['error' => 'Invalid status']);
                return;
        }

        echo json_encode(array_values($tasks));
    }

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
            echo json_encode(['message' => 'Task added successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add task']);
        }
    }

public function updateTask(int $id): void
{
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        return;
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid input']);
        return;
    }

    // Aktualizacja pól: completed, priority, date, title, deleted
    $fieldsToUpdate = [];

    if (array_key_exists('completed', $input)) {
        $fieldsToUpdate['completed'] = (bool)$input['completed'];
    }
    if (array_key_exists('priority', $input)) {
        $fieldsToUpdate['priority'] = $input['priority'];
    }
    if (array_key_exists('date', $input)) {
        $fieldsToUpdate['date'] = $input['date'];
    }
    if (array_key_exists('title', $input)) {
        $fieldsToUpdate['title'] = $input['title'];
    }
    if (array_key_exists('deleted', $input)) {
        $fieldsToUpdate['deleted'] = (bool)$input['deleted'];
    }

    if (empty($fieldsToUpdate)) {
        http_response_code(400);
        echo json_encode(['error' => 'No fields to update']);
        return;
    }

    $success = TaskModel::updateTaskById($id, $fieldsToUpdate);

    if ($success) {
        http_response_code(200);
        echo json_encode(['message' => 'Task updated']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update task']);
    }
}

}
