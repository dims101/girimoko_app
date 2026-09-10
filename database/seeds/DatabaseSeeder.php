<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            DepoSeeder::class,
            DealerSeeder::class,
            AwbSeeder::class,
            ProformaSeeder::class,
            PengirimanSeeder::class,
            TrackingSeeder::class,
        ]);
    }
}
