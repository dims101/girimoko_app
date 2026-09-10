<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProformaSeeder extends Seeder
{
    public function run()
    {
        $awbs       = DB::table('awbs')->pluck('no_awb')->toArray();
        $tipeList   = ['REGULER', 'EXPRESS', 'SAME DAY', null];
        $statusList = ['OPEN', 'CLOSED', 'PARTIAL', null];
        $keteranganList = [
            'Paket dalam kondisi baik',
            'Paket sedikit rusak di bagian luar',
            'Menunggu konfirmasi penerima',
            'Penerima minta reschedule',
            'Alamat tidak lengkap',
            'Paket sudah diterima',
            'Sedang dalam proses pengiriman',
            'Diretur karena penerima tidak ada',
            null,
            null,
            null,
        ];

        $usedAwbs = [];

        for ($i = 1; $i <= 150; $i++) {
            $availableAwbs = array_values(array_diff($awbs, $usedAwbs));
            if (empty($availableAwbs)) break;

            $awb        = $availableAwbs[array_rand($availableAwbs)];
            $usedAwbs[] = $awb;
            $koli       = rand(1, 50);
            $totalKoli  = rand(0, $koli);

            DB::table('proformas')->insert([
                'no_proforma' => 'PRF-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'koli'        => (string)$koli,
                'tipe'        => $tipeList[array_rand($tipeList)],
                'no_awb'      => $awb,
                'total_koli'  => $totalKoli,
                'status'      => $statusList[array_rand($statusList)],
                'keterangan'  => $keteranganList[array_rand($keteranganList)],
                'created_at'  => now()->subDays(rand(0, 180)),
                'updated_at'  => now(),
            ]);
        }
    }
}
