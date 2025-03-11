<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for ($i = 3; $i < 50; $i++) {
            DB::table('users')->insert([
                'fullname' => 'user' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '091234567' . $i,
            ]);
        }


        // User::factory()
        //     ->count(10000)
        //     ->create();
    }
}
