<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name'=>'Super-Admin',
                'guard_name'=>'web',
            ],
            [
                'name'=>'Finance',
                'guard_name'=>'web',
            ],
            [
                'name'=>'Accounts',
                'guard_name'=>'web',
            ],
            [
                'name'=>'Sales',
                'guard_name'=>'web',
            ],
            [
                'name'=>'Supports',
                'guard_name'=>'web',
            ],
            [
                'name'=>'Manager',
                'guard_name'=>'web',
            ],
            [
                'name'=>'Salesman',
                'guard_name'=>'web',
            ],
            [
                'name'=>'Employee',
                'guard_name'=>'web',
            ],
         ];
         foreach($roles as $role){
            Role::create($role);
         }
    }
}
