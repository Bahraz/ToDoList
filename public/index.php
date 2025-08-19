<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Bahraz\ToDoApp\Core\Router;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// session_start();

$router = new Router();

require __DIR__ . '/../app/routes/web.php';
require __DIR__ . '/../app/routes/api.php';

$router->dispatch($_SERVER['REQUEST_URI']);