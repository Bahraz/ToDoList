<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        $users = [
            [
                'email' => 'john@todo.com',
                'password' => '$2y$10$3E5zocfsqqFHPUNfsEDeXuTC3mFrJkTrSRNVkfS1uuK0trrL1Xrr2',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'email' => 'lisa@todo.com',
                'password' => '$2y$10$SRULDFTaye5J1Irp0sBZO.S/7Btj2BAffKltPqfiBSO0m3mlFNvCi',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        $this->table('users')->insert($users)->saveData();
    }
}
