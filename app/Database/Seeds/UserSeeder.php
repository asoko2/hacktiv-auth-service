<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nip' => '1234',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => password_hash('admin', PASSWORD_BCRYPT),
            ],
            [
                'nip' => '111',
                'name' => 'Atasan',
                'email' => 'atasan@gmail.com',
                'password' => password_hash('atasan', PASSWORD_BCRYPT),
            ],
            [
                'nip' => '222',
                'name' => 'HRD',
                'email' => 'hrd@gmail.com',
                'password' => password_hash('hrd', PASSWORD_BCRYPT),
            ],
            [
                'nip' => '333',
                'name' => 'Pengesah',
                'email' => 'pengesah@gmail.com',
                'password' => password_hash('pegawai', PASSWORD_BCRYPT),
            ],
            [
                'nip' => '444',
                'name' => 'Pegawai',
                'email' => 'pegawai@gmail.com',
                'password' => password_hash('pegawai', PASSWORD_BCRYPT),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
