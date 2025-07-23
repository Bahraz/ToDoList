<?php
namespace Bahraz\ToDoApp\Controllers;

use Bahraz\ToDoApp\Models\Task;

class AppController extends BaseController
{
    public function index(): void
    {
        $this->render('home/index');
    }
    
    public function about(): void
    {
        $this->render('layouts/about');
    }

    public function contact(): void
    {
        $this->render('layouts/contact');
    }

    public function addTaskForm(): void
    {
        $this->render('components/addTaskComponent');
    }

    public function viewTodayTask(): void
    {
        $today = date('Y-m-d');
        $tasks = Task::getAll();

        $todayActiveTasks = array_filter($tasks, function ($task) use ($today) {
            return !$task['completed'] && $task['date'] === $today && !$task['deleted'];
        });
        $this->render('components/viewTaskComponent', ['tasks' => $todayActiveTasks]);
    }
    public function viewActiveTask(): void
    {
        $tasks = Task::getAll();
        $activeTasks = array_filter($tasks, function ($task) {
            return !$task['completed']&& !$task['deleted'];
        });
        $this->render('components/viewTaskComponent', ['tasks' => $activeTasks]);
    }

    public function viewCompletedTask(): void
    {
        $tasks = Task::getAll();
        $completedTasks = array_filter($tasks, function ($task) {
            return $task['completed'] === true && !$task['deleted'];
        });
        $this->render('components/viewTaskComponent', ['tasks' => $completedTasks]);
    }

    public function viewTask(): void
    {
        $tasks = Task::getAll();
        $notDeletedTasks = array_filter($tasks, function ($task) {
            return !$task['deleted'];
        });
        $this->render('components/viewTaskComponent', ['tasks' => $notDeletedTasks]);
    }

    public function viewDeletedTask(): void
    {
        $tasks = Task::getAll();
        $deletedTasks = array_filter($tasks, function ($task) {
            return $task['deleted'] === true;
        });
        $this->render('components/viewTaskComponent', ['tasks' => $deletedTasks]);
    }

    public function addTask(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title= $_POST['tittle'] ?? '';
            $priority = $_POST['priority'] ?? 'normal';
            $date = $_POST['date'] ?? date('Y-m-d');

            $tasks=Task::getAll();
            $maxID = 0;
            foreach ($tasks as $task) {
                if ($task['id'] > $maxID) {
                    $maxID = $task['id'];
                }
            }

            $newTask = [
                'id' => $maxID + 1,
                'title' => $title,
                'completed' => false,
                'priority' => $priority,
                'date' => $date,
                'deleted' => false,
            ];

            $tasks[] = $newTask;

            $_SESSION['tasks'] = $tasks;

            header('Location: /app/ViewActiveTask');
            exit;
        }
    }

    public function completeTask()
    {
        session_start();

        $redirect = $_POST['redirect'] ?? '/app/ViewAllTask';
        $taskId = isset($_POST['task_id']) ? (int) $_POST['task_id'] : null;

        if (!$taskId) {
            header('Location: /app/ViewActiveTask');
            exit;
        }

        $tasks = $_SESSION['tasks'] ?? [];

        foreach ($tasks as &$task) {
            if ($task['id'] === $taskId) {
                $task['completed'] = true;
                break;
            }
        }
        unset($task);

        $_SESSION['tasks'] = $tasks;   
        header("Location: $redirect");
        exit;
    }

    public function unCompleteTask()
    {
        session_start();

        $redirect = $_POST['redirect'] ?? '/app/ViewCompletedTask';
        $taskId = isset($_POST['task_id']) ? (int) $_POST['task_id'] : null;

        if (!$taskId) {
            header('Location: /app/ViewCompletedTask');
            exit;
        }

        $tasks = $_SESSION['tasks'] ?? [];

        foreach ($tasks as &$task) {
            if ($task['id'] === $taskId) {
                $task['completed'] = false;
                break;
            }
        }
        unset($task);

        $_SESSION['tasks'] = $tasks;   
        header("Location: $redirect");
        exit;
    }

    public function deleteTask()
    {
        session_start();

        $redirect = $_POST['redirect'] ?? '/app/ViewAllTask';
        $taskId = isset($_POST['task_id']) ? (int) $_POST['task_id'] : null;

        if (!$taskId) {
            header('Location: /app/ViewActiveTask');
            exit;
        }

        $tasks = $_SESSION['tasks'] ?? [];

        foreach ($tasks as &$task) {
            if ($task['id'] === $taskId) {
            $task['deleted'] = true;
            break;
            }   
        }
        unset($task);

        $_SESSION['tasks'] = array_values($tasks);
        header("Location: $redirect");
        exit;
    }

}

