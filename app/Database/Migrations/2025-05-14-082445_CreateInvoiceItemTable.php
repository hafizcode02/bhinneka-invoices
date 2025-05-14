<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoiceItemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'invoice_id' => [
                'type'  => 'int',
                'constraint' => 11,
                'null' => false,
            ],
            'product_id' => [
                'type'  => 'int',
                'constraint' => 11,
                'null' => false,
            ],
            'staff_id' => [
                'type'  => 'int',
                'constraint' => 11,
                'null' => false,
            ],
            'quantity' => [
                'type'  => 'int',
                'constraint' => 11,
                'null' => false,
            ],
            'price' => [
                'type'  => 'int',
                'constraint' => 11,
                'null' => false,
            ],
            'subtotal' => [
                'type'  => 'int',
                'constraint' => 11,
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
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('invoice_id', 'invoices', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('staff_id', 'staffs', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('invoice_items');
    }

    public function down()
    {
        $this->forge->dropForeignKey('invoice_items', 'invoice_items_invoice_id_foreign');
        $this->forge->dropForeignKey('invoice_items', 'invoice_items_product_id_foreign');
        $this->forge->dropForeignKey('invoice_items', 'invoice_items_staff_id_foreign');
        $this->forge->dropTable('invoice_items');
    }
}
