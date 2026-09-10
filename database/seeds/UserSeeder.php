<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name'       => 'Administrator',
            'username'   => 'admin',
            'telepon'    => '081234567890',
            'password'   => Hash::make('12345678'),
            'level'      => 'admin',
            'active'     => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $levels = ['supervisor', 'driver', 'operator'];

        $namaDepan = [
            'Budi', 'Andi', 'Siti', 'Dewi', 'Rudi', 'Hendra', 'Agus', 'Dian',
            'Eko', 'Fitri', 'Galih', 'Hani', 'Irwan', 'Joko', 'Kartika',
            'Lukman', 'Mira', 'Nanda', 'Oscar', 'Putri', 'Rizal', 'Sari',
            'Tono', 'Umi', 'Vino', 'Wati', 'Yudi', 'Zahra', 'Bagas', 'Citra',
        ];

        $namaBelakang = [
            'Santoso', 'Wijaya', 'Kusuma', 'Prasetyo', 'Hidayat', 'Nugroho',
            'Saputra', 'Setiawan', 'Raharjo', 'Purnomo', 'Susanto', 'Hartono',
            'Wibowo', 'Suryadi', 'Budiman', 'Gunawan', 'Firmansyah', 'Hakim',
        ];

        for ($i = 1; $i <= 30; $i++) {
            $nama = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];
            DB::table('users')->insert([
                'name'       => $nama,
                'username'   => 'user' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'telepon'    => '08' . rand(100000000, 999999999),
                'password'   => Hash::make('password'),
                'level'      => $levels[array_rand($levels)],
                'active'     => rand(0, 4) > 0 ? '1' : '0',
                'created_at' => now()->subDays(rand(30, 365)),
                'updated_at' => now(),
            ]);
        }
    }
}
