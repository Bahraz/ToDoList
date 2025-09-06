<?php


// Define API routes
$router->get('/api/tasks', 'Api\ApiController@index');       
$router->post('/api/add-task', 'Api\TaskController@addTask');  
$router->patch('/api/tasks/{id}', 'Api\TaskController@updateTask'); 

$router->post('/api/login', 'Api\UserController@loginUser');
$router->post('/api/register', 'Api\UserController@registerUser');
$router->post('/api/logout', 'Api\UserController@logoutUser');