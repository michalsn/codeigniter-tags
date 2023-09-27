<?php

namespace Michalsn\CodeIgniterTags\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTagTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'varchar', 'constraint' => 32, 'null' => false],
            'slug'       => ['type' => 'varchar', 'constraint' => 32, 'null' => false],
            'created_at' => ['type' => 'datetime', 'null' => false],
            'updated_at' => ['type' => 'datetime', 'null' => false],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('tags', true);

        $this->forge->addField([
            'tag_id'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'taggable_id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'taggable_type' => ['type' => 'varchar', 'constraint' => 32, 'null' => false],
        ]);
        $this->forge->addUniqueKey(['tag_id', 'taggable_id', 'taggable_type']);
        $this->forge->createTable('taggable', true);
    }

    public function down()
    {
        $this->forge->dropTable('tags', true);
        $this->forge->dropTable('taggable', true);
    }
}
