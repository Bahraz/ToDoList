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

    public function addTask(): void
    {
        $this->render('components/addTaskComponent');
    }

    public function viewTodayTask(): void
    {
        $today = date('Y-m-d');
        $tasks = Task::getAll();

        $todayTasks = array_filter($tasks, function ($task) use ($today) {
            return $task['date'] === $today;
        });
        $this->render('components/viewTaskComponent', ['tasks' => $todayTasks]);
    }
    public function viewActiveTask(): void
    {
        $tasks = Task::getAll();
        $activeTasks = array_filter($tasks, function ($task) {
            return !$task['completed'];
        });
        $this->render('components/viewTaskComponent', ['tasks' => $activeTasks]);
    }

    public function viewCompletedTask(): void
    {
        $tasks = Task::getAll();
        $completedTasks = array_filter($tasks, function ($task) {
            return $task['completed'] === true;
        });
        $this->render('components/viewTaskComponent', ['tasks' => $completedTasks]);
    }

    public function viewTask(): void
    {
        $tasks = Task::getAll();
        $this->render('components/viewTaskComponent', ['tasks' => $tasks]);
    }
}

