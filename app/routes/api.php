<?php

// Define API routes
$router->get('/api/tasks', 'ApiController@index');
$router->post('/api/AddTask', 'ApiController@addTask');
$router->patch('/api/CompleteTask/{id}', 'ApiController@completeTask');
$router->patch('/api/UncompleteTask/{id}', 'ApiController@unCompleteTask');
$router->delete('/api/DeleteTask/{id}', 'ApiController@deleteTask');