<?php

namespace Database\Seeders;

use App\Models\Family_tree;
use App\Models\Members;
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
        \App\Models\User::factory(10)->create();
        \App\Models\Family_tree::factory(5)->create();
        \App\Models\Members::factory(10)->create();

    }
}
