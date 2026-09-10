<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DealerSeeder extends Seeder
{
    public function run()
    {
        $depoData = [
            ['dds' => 'DDS 1', 'depo' => 'TAMBUN',   'rayon' => 'Rayon A'],
            ['dds' => 'DDS 2', 'depo' => 'TAMBUN',   'rayon' => 'Rayon B'],
            ['dds' => 'DDS 2', 'depo' => 'BANDUNG',  'rayon' => 'Rayon C'],
            ['dds' => 'DDS 3', 'depo' => 'PEMALANG', 'rayon' => 'Rayon D'],
            ['dds' => 'DDS 3', 'depo' => 'SEMARANG', 'rayon' => 'Rayon E'],
            ['dds' => 'DDS 3', 'depo' => 'SOLO',     'rayon' => 'Rayon F'],
        ];

        $namaDealer = [
            'Maju Jaya Motor', 'Sumber Rejeki', 'Karya Mandiri', 'Sejahtera Abadi',
            'Berkah Jaya', 'Surya Motor', 'Anugrah Teknik', 'Prima Setia',
            'Harapan Baru', 'Duta Niaga', 'Global Teknik', 'Nusantara Motor',
            'Cahaya Indah', 'Bintang Timur', 'Mutiara Abadi', 'Sentosa Jaya',
            'Permata Motor', 'Mega Teknik', 'Arjuna Motor', 'Pandawa Jaya',
        ];

        $kotaList = [
            'Bekasi', 'Tambun', 'Cikarang', 'Bandung', 'Cimahi',
            'Pemalang', 'Semarang', 'Demak', 'Solo', 'Sukoharjo',
        ];

        $provinsiList = [
            'Jawa Barat', 'Jawa Tengah', 'DI Yogyakarta',
        ];

        $jalanList = ['Sudirman', 'Gatot Subroto', 'Ahmad Yani', 'Diponegoro', 'Pahlawan', 'Merdeka', 'Veteran'];

        for ($i = 1; $i <= 60; $i++) {
            $depo = $depoData[array_rand($depoData)];
            $kota = $kotaList[array_rand($kotaList)];

            DB::table('dealers')->insert([
                'kode_dealer' => 'DLR-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama_dealer' => $namaDealer[array_rand($namaDealer)] . ' ' . $kota,
                'alamat'      => 'Jl. ' . $jalanList[array_rand($jalanList)] . ' No. ' . rand(1, 200),
                'provinsi'    => $provinsiList[array_rand($provinsiList)],
                'kota'        => $kota,
                'kodepos'     => (string)rand(10000, 99999),
                'dds'         => $depo['dds'],
                'depo'        => $depo['depo'],
                'rayon'       => $depo['rayon'],
                'target'      => (string)rand(50, 500),
                'created_at'  => now()->subDays(rand(30, 365)),
                'updated_at'  => now(),
            ]);
        }
    }
}
