<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => 'Malsi',
            'username' => 'malsinur23',
            'password' => bcrypt('12345678'),
            'level' => 'Super Admin',
     ]);

    }
}
