<?php
namespace Bahraz\ToDoApp\Controllers\Web;

use Bahraz\ToDoApp\Controllers\BaseController;


class AppController extends BaseController
{
    
    public function index(): void
    {
        $this->startSession();
        $this->render('home/index');
    }
    
    public function about(): void
    {
        $this->startSession();
        $this->render('layouts/about');
    }

    public function contact(): void
    {
        $this->startSession();
        $this->render('layouts/contact');
    }

    public function addTaskForm(): void
    {
        $this->startSession();
        $this->render('Components/Forms/addTaskForm');
    }

    public function viewTask(string $status = 'all'): void
    {
        $this->startSession();
        $this->render('Components/Lists/viewTask', ['status' => $status]);
    }

    public function loginForm(): void
    {   
        $this->redirectIfAuthenticated();
        $this->render('Components/Forms/loginForm');
    }
    public function registerForm(): void
    {
        $this->redirectIfAuthenticated();
        $this->render('Components/Forms/registerForm');
    }
}

