<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use Database\Seeders\DivisionSeeder; 
// use Database\Seeders\DistrictSeeder; 
// use Database\Seeders\ThanaSeeder; 
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
            //    $this->call(DivisionSeeder::class);
            //    $this->call(DistrictSeeder::class);
               $this->call(ThanaSeeder::class);

    }
}
