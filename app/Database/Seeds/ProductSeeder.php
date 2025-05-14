<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'code' => 'PR01',
                'name' => 'Ban Luar 1.75-2.125',
                'unit' => 'Pcs',
                'price' => 10000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'PR02',
                'name' => 'Baut Ukuran M5x20',
                'unit' => 'Pcs',
                'price' => 20000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'PR03',
                'name' => 'Kunci L 5mm',
                'unit' => 'Pcs',
                'price' => 15000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'PR04',
                'name' => 'Minyak Rem DOT 4',
                'unit' => 'Liter',
                'price' => 50000,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Oli Mesin 10W-40',
                'code' => 'PR05',
                'price' => 80000,
                'unit' => 'Liter',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'PR06',
                'name' => 'Baut Ukuran M6x30',
                'price' => 25000,
                'unit' => 'Dus',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // Using Query Builder
        $this->db->table('products')->insertBatch($data);
    }
}
