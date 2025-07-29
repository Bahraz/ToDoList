<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Bahraz\ToDoApp\Router;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Initialize router
$router = new Router();

$requestUri = $_SERVER['REQUEST_URI'];

$path = parse_url($requestUri, PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));

if (count($segments) === 3 && $segments[0] === 'tasks' && $segments[1] === 'view') {
        $status = $segments[2];
    
        $controller = new Bahraz\ToDoApp\Controllers\AppController();
        $controller->viewTask($status);
        exit;
    }
    
// Define routes for the application
$router->get('/', 'AppController@index');
$router->get('/home/index', 'AppController@index');
$router->get('/tasks/form/add', 'AppController@addTaskForm');
$router->get('/about', 'AppController@about');
$router->get('/contact', 'AppController@contact');

// Define API routes
$router->get('/api/tasks', 'ApiController@index');
$router->post('/api/AddTask', 'ApiController@addTask');
$router->post('/api/CompleteTask', 'ApiController@completeTask');
$router->post('/api/UncompleteTask', 'ApiController@unCompleteTask');
$router->post('/api/DeleteTask', 'ApiController@deleteTask');

// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI']);
