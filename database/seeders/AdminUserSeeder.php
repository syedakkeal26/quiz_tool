<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'role'=>'admin'
        ]);
        User::create([
            'name' => 'Subadmin',
            'email' => 'subadmin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
