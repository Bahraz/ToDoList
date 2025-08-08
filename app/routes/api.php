<?php

// Define API routes
$router->get('/api/tasks', 'Api\TaskController@index');       
$router->post('/api/tasks', 'Api\TaskController@addTask');  
$router->patch('/api/tasks/{id}', 'Api\TaskController@updateTask'); 

$router->post('/api/login', 'Api\UserController@login');
$router->post('/api/register', 'Api\UserController@register');
