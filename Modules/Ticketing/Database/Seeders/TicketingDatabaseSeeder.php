<?php

namespace Modules\Ticketing\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ticketing\Database\Seeders\ComplainTypeSeeder;
use Modules\Ticketing\Database\Seeders\SupportQuickSolutionSeeder;

class TicketingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(SupportQuickSolutionSeeder::class);
        // $this->call(ComplainTypeSeeder::class);
    }
}
