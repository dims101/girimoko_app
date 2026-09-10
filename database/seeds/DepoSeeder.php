<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepoSeeder extends Seeder
{
    public function run()
    {
        $depos = [
            ['dds' => 'DDS 1', 'depo' => 'TAMBUN',   'rayon' => 'Rayon A'],
            ['dds' => 'DDS 2', 'depo' => 'TAMBUN',   'rayon' => 'Rayon B'],
            ['dds' => 'DDS 2', 'depo' => 'BANDUNG',  'rayon' => 'Rayon C'],
            ['dds' => 'DDS 3', 'depo' => 'PEMALANG', 'rayon' => 'Rayon D'],
            ['dds' => 'DDS 3', 'depo' => 'SEMARANG', 'rayon' => 'Rayon E'],
            ['dds' => 'DDS 3', 'depo' => 'SOLO',     'rayon' => 'Rayon F'],
        ];

        foreach ($depos as $depo) {
            DB::table('depos')->insert([
                'dds'        => $depo['dds'],
                'depo'       => $depo['depo'],
                'rayon'      => $depo['rayon'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
