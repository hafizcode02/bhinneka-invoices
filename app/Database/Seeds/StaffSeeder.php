<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Arief Satria',
                'email' => 'ariefsatria@mail.com',
                'gender' => 'Pria',
                'phone' => '081234567890',
                'address' => 'Jl. Raya No. 1, Jakarta',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewilestari@mail.com',
                'gender' => 'Wanita',
                'phone' => '082345678901',
                'address' => 'Jl. Raya No. 2, Bandung',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Ilham',
                'email' =>  'ilhamaja@mail.com',
                'gender' => 'Pria',
                'phone' => '083456789012',
                'address' => 'Jl. Raya No. 3, Surabaya',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $this->db->table('staffs')->insertBatch($data);
    }
}
