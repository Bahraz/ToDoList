<?php

// web routes 
$router->get('/', 'AppController@index');
$router->get('/home/index', 'AppController@index');
$router->get('/about', 'AppController@about');
$router->get('/contact', 'AppController@contact');

// Component routes
$router->get('/tasks/form/add', 'AppController@addTaskForm');
$router->get('/tasks/view/{status}', 'AppController@viewTask');

