<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoiceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'invoice_number' => [
                'type'  => 'varchar',
                'constraint' => 255,
                'null' => false,
                'unique' => true,
            ],
            'staff_id' => [
                'type'  => 'int',
                'constraint' => 11,
                'null' => false,
            ],
            'company_to' => [
                'type'  => 'varchar',
                'constraint' => 255,
                'null' => false,
            ],
            'company_address' => [
                'type'  => 'text',
                'null' => false,
            ],
            'attention_to' => [
                'type'  => 'varchar',
                'constraint' => 255,
                'null' => false,
            ],
            'created_at' => [
                'type'  => 'datetime',
                'null' => true,
            ],
            'updated_at' => [
                'type'  => 'datetime',
                'null' => true,
            ],
            'deleted_at' => [
                'type'  => 'datetime',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('staff_id', 'staffs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('invoices');
    }

    public function down()
    {
        $this->forge->dropForeignKey('invoices', 'invoices_user_id_foreign');
        $this->forge->dropForeignKey('invoices', 'invoices_staff_id_foreign');
        $this->forge->dropTable('invoices');
    }
}
