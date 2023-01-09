<?php

namespace Database\Seeders;

use App\Models\Dataencoding\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'name'=>'Accounts',
            ],
            [
                'name'=>'Marketing',
            ],
            [
                'name'=>'Sales',
            ],
            [
                'name'=>'Production',
            ],
            [
                'name'=>'Purchase',
            ],
            [
                'name'=>'Procurement',
            ],
            [
                'name'=>'Plant',
            ]
         ];
         foreach($departments as $department){
            Department::create($department);
         }
    }
}
