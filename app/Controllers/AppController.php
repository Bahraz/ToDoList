<?php
namespace Bahraz\ToDoApp\Controllers;


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

    public function viewTask(string $status = 'all'): void
    {
        $this->render('components/viewTaskComponent', ['status' => $status]);
    }
}

