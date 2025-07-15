<?php
namespace Bahraz\ToDoApp\Controllers;

use Bahraz\ToDoApp\Models\Task;

class AppController extends BaseController
{
    public function index(): void
    {
        $this->render('home/index');
    }
    
    public function viewTask(): void
    {
        $tasks = Task::getAll();
        $this->render('components/viewTaskComponent', ['tasks' => $tasks]);
    }

    public function addTask(): void
    {
        $this->render('components/addTaskComponent');
    }

    public function about(): void
    {
        $this->render('layouts/about');
    }

    public function contact(): void
    {
        $this->render('layouts/contact');
    }
}
