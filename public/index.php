<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Bahraz\ToDoApp\Router;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Initialize router
$router = new Router();

// Define routes
$router->get('/', 'AppController@index');
$router->get('/home/index', 'AppController@index');
$router->get('/app/AddTask', 'AppController@addTask');
$router->get('/app/ViewTodayTask', 'AppController@viewTodayTask');
$router->get('/app/ViewActiveTask', 'AppController@viewActiveTask');
$router->get('/app/ViewCompletedTask', 'AppController@viewCompletedTask');
$router->get('/app/ViewTask', 'AppController@viewTask');
$router->get('/about', 'AppController@about');
$router->get('/contact', 'AppController@contact');
// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI']);
