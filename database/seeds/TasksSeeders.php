<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class TasksSeeders extends AbstractSeed
{

public function getDependencies(): array
{
    return [
        UsersSeeder::class,
    ];
}



    public function run(): void
    {
        $tasks = [
            ['user_id' => 1, 'title' => 'Buy groceries', 'completed' => 0, 'priority' => 'low', 'date' => '2025-08-18', 'deleted' => 0],
            ['user_id' => 1, 'title' => 'Clean the kitchen', 'completed' => 1, 'priority' => 'low', 'date' => '2025-08-21', 'deleted' => 0],
            ['user_id' => 1, 'title' => 'Write report', 'completed' => 0, 'priority' => 'normal', 'date' => '2025-08-18', 'deleted' => 0],
            ['user_id' => 1, 'title' => 'Go jogging', 'completed' => 1, 'priority' => 'normal', 'date' => '2025-08-23', 'deleted' => 0],
            ['user_id' => 1, 'title' => 'Fix the server issue', 'completed' => 0, 'priority' => 'high', 'date' => '2025-08-18', 'deleted' => 0],
            ['user_id' => 1, 'title' => 'Prepare presentation', 'completed' => 1, 'priority' => 'high', 'date' => '2025-08-25', 'deleted' => 0],
            ['user_id' => 1, 'title' => 'Old shopping list', 'completed' => 0, 'priority' => 'low', 'date' => '2025-08-18', 'deleted' => 1],
            ['user_id' => 1, 'title' => 'Canceled meeting prep', 'completed' => 1, 'priority' => 'normal', 'date' => '2025-08-12', 'deleted' => 1],
            ['user_id' => 2, 'title' => 'Read a book', 'completed' => 0, 'priority' => 'low', 'date' => '2025-08-18', 'deleted' => 0],
            ['user_id' => 2, 'title' => 'Do laundry', 'completed' => 1, 'priority' => 'low', 'date' => '2025-08-21', 'deleted' => 0],
            ['user_id' => 2, 'title' => 'Update CV', 'completed' => 0, 'priority' => 'normal', 'date' => '2025-08-18', 'deleted' => 0],
            ['user_id' => 2, 'title' => 'Plan weekend trip', 'completed' => 1, 'priority' => 'normal', 'date' => '2025-08-23', 'deleted' => 0],
            ['user_id' => 2, 'title' => 'Prepare dinner party', 'completed' => 0, 'priority' => 'high', 'date' => '2025-08-18', 'deleted' => 0],
            ['user_id' => 2, 'title' => 'Finish coding task', 'completed' => 1, 'priority' => 'high', 'date' => '2025-08-25', 'deleted' => 0],
            ['user_id' => 2, 'title' => 'Abandoned blog draft', 'completed' => 0, 'priority' => 'normal', 'date' => '2025-08-18', 'deleted' => 1],
            ['user_id' => 2, 'title' => 'Old shopping task', 'completed' => 1, 'priority' => 'high', 'date' => '2025-08-12', 'deleted' => 1],
        ];

        $this->table('tasks')->insert($tasks)->saveData();
    }
}
