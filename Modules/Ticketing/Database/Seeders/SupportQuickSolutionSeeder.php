<?php

namespace Modules\Ticketing\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ticketing\Entities\SupportQuickSolution;

class SupportQuickSolutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $solutions = [
            'Checked & Found Service Ok',
            'Device Restarted',
            'Switch Port Restarted',
            'Loose Connectivity',
            'Wrong Port Connection',
            'Others'
        ];

        foreach($solutions as $solution) {
            SupportQuickSolution::create([
                'name' => $solution,
                'created_by'    => 1
            ]);
        }
    }
}
