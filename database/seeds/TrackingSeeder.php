<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrackingSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')->pluck('username')->toArray();
        $awbs  = DB::table('awbs')->pluck('no_awb')->toArray();

        $lokasiList = [
            'Gudang Jakarta Pusat',
            'Depo Bogor',
            'Sortir Bandung',
            'Hub Semarang',
            'Depo Surabaya',
            'Dalam Perjalanan',
            'Tiba di Tujuan',
            'Proses Bongkar Muat',
            'Menunggu Kurir',
            'Sudah Diserahkan ke Penerima',
        ];

        $commentList = [
            'Paket diterima di gudang',
            'Sedang dalam proses sortir',
            'Paket dalam perjalanan ke depo tujuan',
            'Paket tiba di depo tujuan',
            'Paket sedang dikirim ke penerima',
            'Paket berhasil diserahkan',
            'Penerima tidak ada di tempat, akan dicoba besok',
            'Alamat tidak ditemukan, konfirmasi ke pengirim',
            'Paket diretur ke pengirim',
            'Proses pengiriman selesai',
        ];

        $trackings = [];
        foreach ($awbs as $awb) {
            $jumlah  = rand(1, 5);
            $tanggal = Carbon::now()->subDays(rand(0, 60));

            for ($j = 0; $j < $jumlah; $j++) {
                $tanggal = $tanggal->copy()->addHours(rand(2, 24));
                $trackings[] = [
                    'ds'         => $awb,
                    'lokasi'     => $lokasiList[array_rand($lokasiList)],
                    'id_user'    => $users[array_rand($users)],
                    'comment'    => $commentList[array_rand($commentList)],
                    'created_at' => $tanggal->format('Y-m-d H:i:s'),
                    'updated_at' => $tanggal->format('Y-m-d H:i:s'),
                ];
            }

            if (count($trackings) >= 500) break;
        }

        foreach (array_chunk($trackings, 100) as $chunk) {
            DB::table('trackings')->insert($chunk);
        }
    }
}
