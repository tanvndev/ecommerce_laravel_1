<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('users')->insert([
        //     'fullname' => 'Vu Ngoc Tan',
        //     'email' => 'admin' . '@gmail.com',
        //     'password' => Hash::make('123456'),
        // ]);

        User::factory()
            ->count(100000)
            ->create();
    }
}
