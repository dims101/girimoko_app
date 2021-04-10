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
            'name' => 'Developers',
            'username' => 'admin',
            'telepon' => '0813927465',
            'password' => bcrypt('12345678'),
            'level' => 'Super Admin',
     ]);

    }
}
