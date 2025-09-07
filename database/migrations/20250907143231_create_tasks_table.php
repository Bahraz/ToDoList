<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTasksTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('tasks', ['id' => 'id', 'primary_key' => 'id']);
        $table->addColumn('user_id', 'integer', ['signed' => false, 'null' => false])
              ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('completed', 'boolean', ['default' => 0, 'null' => false])
              ->addColumn('priority', 'enum', ['values' => ['low','normal','high'], 'default' => 'normal', 'null' => false])
              ->addColumn('date', 'date', ['null' => false])
              ->addColumn('deleted', 'boolean', ['default' => 0, 'null' => false])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
              ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
              ->create();
    }
}
