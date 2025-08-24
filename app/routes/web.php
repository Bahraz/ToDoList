<?php

// web routes 
$router->get('/', 'Web\AppController@index');
$router->get('/home', 'Web\AppController@index');
$router->get('/home/index', 'Web\AppController@index');
$router->get('/about', 'Web\AppController@about');
$router->get('/contact', 'Web\AppController@contact');

// Component routes
$router->get('/tasks/form/add', 'Web\AppController@addTaskForm');
$router->get('/login', 'Web\AppController@loginForm');
$router->get('/register', 'Web\AppController@registerForm');
$router->get('/tasks/view/{status}', 'Web\AppController@viewTask');

