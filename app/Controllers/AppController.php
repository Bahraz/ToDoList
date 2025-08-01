<?php
namespace Bahraz\ToDoApp\Controllers;

use Bahraz\ToDoApp\Models\Task;

class AppController extends BaseController
{
    private function fetchApi(string $url): ?array
    {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 5); // limit czasu, opcjonalnie

        $response = curl_exec($curlHandle);
        $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);

        if ($httpCode === 200 && $response !== false) {
            return json_decode($response, true);
        }
    return null;
    }

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

