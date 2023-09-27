<?php

namespace Tests\Support\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTestTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'varchar', 'constraint' => 32, 'null' => false],
            'width'      => ['type' => 'smallint', 'constraint' => 5, 'null' => false],
            'height'     => ['type' => 'smallint', 'constraint' => 5, 'null' => false],
            'created_at' => ['type' => 'datetime', 'null' => false],
            'updated_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('images', true);

        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'      => ['type' => 'varchar', 'constraint' => 64, 'null' => false],
            'body'       => ['type' => 'text', 'null' => false],
            'created_at' => ['type' => 'datetime', 'null' => false],
            'updated_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('posts', true);
    }

    public function down()
    {
        $this->forge->dropTable('images', true);
        $this->forge->dropTable('posts', true);
    }
}
