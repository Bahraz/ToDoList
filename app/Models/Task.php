<?php

namespace Bahraz\ToDoApp\Models;

class Task
{
    public static function getAll()
    {
        return [
            ['id' => 1, 'title' => 'Zrób zakupy', 'completed' => false],
            ['id' => 2, 'title' => 'Odebrać paczkę', 'completed' => true],
        ];
    }
}
