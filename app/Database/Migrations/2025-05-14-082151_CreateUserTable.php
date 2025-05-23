<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id'          => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'auto_increment' => true,
                ],
                'name'    => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'email'       => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'password'    => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                ],
                'role'        => [
                    'type'       => 'ENUM',
                    'constraint' => ['superadmin', 'admin'],
                    'default'    => 'admin',
                ],
                'created_at'  => [
                    'type'      => 'DATETIME',
                    'null'      => true,
                ],
                'updated_at'  => [
                    'type'      => 'DATETIME',
                    'null'      => true,
                ],
            ]
        );
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
