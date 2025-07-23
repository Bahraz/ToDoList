<?php

namespace Bahraz\ToDoApp\Models;

class Task
{
public static function getAll()
{
    session_start();

    if (!isset($_SESSION['tasks'])) {
        $_SESSION['tasks'] = [
            [
                'id' => 1,
                'title' => 'Buy groceries',
                'completed' => false,
                'priority' => 'low',
                'date' => '2025-07-19',
                'deleted' => false,
            ],
            [
                'id' => 2,
                'title' => 'Take the dog for a walk',
                'completed' => false,
                'priority' => 'high',
                'date' => '2025-07-15',
                'deleted' => false,
            ],
            [
                'id' => 32,
                'title' => 'Go to the gym',
                'completed' => false,
                'priority' => 'normal',
                'date' => '2025-07-15',
                'deleted' => false,
            ],
            [
                'id' => 4,
                'title' => 'Finish the project report',
                'completed' => true,
                'priority' => 'high',
                'date' => '2025-07-10',
                'deleted' => false,
            ],
            [
                'id' => 5,
                'title' => 'Read a book',
                'completed' => true,
                'priority' => 'low',
                'date' => '2025-07-25',
                'deleted' => false,
            ],
        ];
    }

    return $_SESSION['tasks'];
}

}
