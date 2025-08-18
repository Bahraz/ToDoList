<?php
namespace Bahraz\ToDoApp\Controllers\Web;

use Bahraz\ToDoApp\Controllers\BaseController;


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
        $this->render('Components/Forms/addTaskForm');
    }

    public function viewTask(string $status = 'all'): void
    {
        $this->render('Components/Lists/viewTask', ['status' => $status]);
    }

    public function loginForm(): void
    {
        $this->render('Components/Forms/loginForm');
    }
    public function registerForm(): void
    {
        $this->render('Components/Forms/registerForm');
    }
}

