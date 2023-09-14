<?php

namespace Database\Seeders;

use App\Models\Dataencoding\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employes = [ 
            [ 'name'=>'Sales & Marketing', 'designation_id'=>1, 'department_id'=>1, 'branch_id'=>1, 'email'=>''],
        ];

        foreach($employes as $employe){
            Employee::create($employe);
         }
    }
}
