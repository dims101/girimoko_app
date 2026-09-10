<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AwbSeeder extends Seeder
{
    public function run()
    {
        $dealers    = DB::table('dealers')->pluck('kode_dealer')->toArray();
        $statusList = ['DELIVERED', 'ON PROCESS', 'PENDING', null];

        for ($i = 1; $i <= 200; $i++) {
            $tanggal = Carbon::now()->subDays(rand(0, 180));
            $status  = $statusList[array_rand($statusList)];

            DB::table('awbs')->insert([
                'no_awb'        => 'AWB-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'no_ds'         => 'DS-' . str_pad(rand(1, 999), 4, '0', STR_PAD_LEFT),
                'kode_dealer'   => $dealers[array_rand($dealers)],
                'tanggal_ds'    => $tanggal->format('Y-m-d'),
                'status'        => $status,
                'keterangan'    => $status === 'PENDING' ? 'Menunggu konfirmasi' : ($status === 'DELIVERED' ? 'Terkirim' : null),
                'id_pengiriman' => $status === 'DELIVERED' ? 'PGR-' . str_pad(rand(1, 100), 4, '0', STR_PAD_LEFT) : null,
                'created_at'    => $tanggal,
                'updated_at'    => $tanggal->copy()->addDays(rand(0, 3)),
            ]);
        }
    }
}
