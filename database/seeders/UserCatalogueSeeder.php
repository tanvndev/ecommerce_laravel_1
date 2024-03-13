<?php

namespace Database\Seeders;

use App\Models\UserCatalogue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserCatalogue::factory()
            ->count(1000)
            ->create();
    }
}
