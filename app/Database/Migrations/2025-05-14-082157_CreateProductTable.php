<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'code'       => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'name'        => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'unit'       => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'price'       => [
                'type'       => 'INT',
                'constraint' => 11,
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
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
