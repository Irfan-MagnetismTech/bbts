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
                'name'=>'Sales & Marketing',
            ],
            [
                'name'=>'Systems & Services',
            ],
            [
                'name'=>'Maintenance',
            ],
            [
                'name'=>'Operation',
            ],
            [
                'name'=>'Accounts',
            ],
            [
                'name'=>'Infrastructure & CRM',
            ],
            [
                'name'=>'SCM',
            ],
            [
                'name'=>'HRM',
            ],
            [
                'name'=>'Network',
            ],
            [
                'name'=>'HR & Admin',
            ]
         ];
         foreach($departments as $department){
            Department::create($department);
         }
    }
}
