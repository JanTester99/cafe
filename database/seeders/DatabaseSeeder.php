<?php

namespace Database\Seeders;

use App\Models\Drink;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Drink::factory(20)->create();
        User::factory(10)->create();
    }
}
