<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Branch;

class BranchSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();

        // $this->call("OthersTableSeeder");

        $branchs = [ 
            ['name' => 'Feni.'],
            ['name' => 'Rangpur'],
            ['name' => 'Rajshahi'],
            ['name' => 'CTG'],
            ['name' => 'Savar'],
            ['name' => 'Khulna'],
            ['name' => 'Feni'],
            ['name' => 'Coxs Bazar'],
            ['name' => 'Dhaka'],
            ['name' => 'Cumilla'],
            ['name' => 'Barishal'],
            ['name' => 'Uttara'],
            ['name' => 'Bogra'],
            ['name' => 'Comilla'],
            ['name' => 'Mongla'],
            ['name' => 'Dhaka'],
         ];
         foreach($branchs as $branch){
            Branch::create($branch);
         }
    }
}
















