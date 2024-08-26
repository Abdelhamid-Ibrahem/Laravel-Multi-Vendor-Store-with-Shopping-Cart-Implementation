<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Abdelhamid Ibrahim',
            'email' => 'Abdelhami12d@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '01022579851',
        ]);

        DB::table('users')->insert([
            'name' => 'System Admin',
            'email' => 'Abdelhami24d@gmail.com',
            'password' => Hash::make('password'),
            'phone_number' => '01022084035',
        ]);


    }
}
