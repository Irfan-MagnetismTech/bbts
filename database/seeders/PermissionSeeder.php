<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name'=>'user-create',
                'guard_name'=>'web',
            ],
            [
                'name'=>'user-edit',
                'guard_name'=>'web',
            ],
            [
                'name'=>'user-show',
                'guard_name'=>'web',
            ],
            [
                'name'=>'user-update',
                'guard_name'=>'web',
            ],
            [
                'name'=>'user-delete',
                'guard_name'=>'web',
            ]
        ];

        foreach($permissions as $permission){
            Permission::create($permission);
         }
    }
}
