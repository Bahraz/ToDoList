<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Bahraz\SettlersWars\Core\Router;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Initialize router
$router = new Router();

// Define routes
$router->get('/', 'HomeController@index');
$router->get('/home/index', 'HomeController@index');

// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI']);
