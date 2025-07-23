<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Bahraz\ToDoApp\Router;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Initialize router
$router = new Router();

// Define routes for the application
$router->get('/', 'AppController@index');
$router->get('/home/index', 'AppController@index');
$router->get('/app/AddTaskForm', 'AppController@addTaskForm');
$router->get('/app/ViewTodayTask', 'AppController@viewTodayTask');
$router->get('/app/ViewActiveTask', 'AppController@viewActiveTask');
$router->get('/app/ViewCompletedTask', 'AppController@viewCompletedTask');
$router->get('/app/ViewTask', 'AppController@viewTask');
$router->get('/app/ViewDeletedTask', 'AppController@viewDeletedTask');
$router->get('/about', 'AppController@about');
$router->get('/contact', 'AppController@contact');

//Define routes for the actions
$router->post('/app/AddTask', 'AppController@addTask');
$router->post('/app/CompleteTask', 'AppController@completeTask');
$router->post('/app/DeleteTask', 'AppController@deleteTask');
$router->post('/app/UncompleteTask', 'AppController@unCompleteTask');

// Define API routes
$router->get('/api/tasks', 'ApiController@index');

// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI']);
