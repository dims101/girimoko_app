<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengirimanSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')->pluck('username')->toArray();

        $penerima = [
            'Budi Santoso', 'Andi Wijaya', 'Siti Rahayu', 'Dewi Kusuma',
            'Hendra Prasetyo', 'Agus Hidayat', 'Dian Nugroho', 'Eko Saputra',
            'Fitri Setiawan', 'Galih Raharjo', 'Hani Purnomo', 'Irwan Susanto',
        ];

        $kendaraan = [
            'B 1234 ABC', 'B 5678 DEF', 'D 9012 GHI',
            'F 3456 JKL', 'G 7890 MNO', 'H 1111 PQR',
        ];

        for ($i = 1; $i <= 100; $i++) {
            $tanggal = Carbon::now()->subDays(rand(0, 180));

            DB::table('pengirimans')->insert([
                'username'       => $users[array_rand($users)],
                'tanggal_terima' => $tanggal->format('Y-m-d'),
                'waktu_terima'   => sprintf('%02d:%02d:00', rand(7, 17), rand(0, 59)),
                'penerima'       => $penerima[array_rand($penerima)],
                'foto_awb'       => 'foto_awb_' . $i . '.jpg',
                'no_kendaraan'   => $kendaraan[array_rand($kendaraan)],
                'target_aktual'  => ['TARGET', 'AKTUAL'][array_rand(['TARGET', 'AKTUAL'])],
                'created_at'     => $tanggal,
                'updated_at'     => $tanggal,
            ]);
        }
    }
}
