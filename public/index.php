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
$router->get('/', 'HomeController@index');
$router->get('/home/index', 'HomeController@index');
$router->get('/app/ViewAllTask', 'AppController@viewTask');
$router->get('/app/ViewTodayTask', 'AppController@viewTodayTask');
$router->get('/app/AddTask', 'AppController@addTask');
$router->get('/about', 'AppController@about');
// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI']);
