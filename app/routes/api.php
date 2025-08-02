<?php

// Define API routes
$router->get('/api/tasks', 'ApiController@index');
$router->post('/api/AddTask', 'TaskController@addTask');
$router->patch('/api/updatetask/{action}/{id}', 'TaskController@updateTask');
$router->delete('/api/updatetask/delete/{id}', 'TaskController@updateTask');