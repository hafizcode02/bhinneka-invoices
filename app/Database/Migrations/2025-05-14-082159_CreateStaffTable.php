<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStaffTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'name'        => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'email'       => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'gender'        => [
                'type'       => 'ENUM',
                'constraint' => ['Pria', 'Wanita'],
            ],
            'phone'       => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'address'     => [
                'type'       => 'TEXT',
            ],
            'created_at'  => [
                'type'      => 'DATETIME',
                'null'      => true,
            ],
            'updated_at'  => [
                'type'      => 'DATETIME',
                'null'      => true,
            ],
            'deleted_at'  => [
                'type'      => 'DATETIME',
                'null'      => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('staffs');
    }

    public function down()
    {
        $this->forge->dropTable('staffs');
    }
}
