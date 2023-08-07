<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Modules\Admin\Entities\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super-Admin',
            'email' => 'sadmin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$nBcFmdKHFT/R5X.ntbJTjuYke7gEabhg55CJTCanOwUzkpOyZfhB2', // sadmin@gmail.com
            'remember_token' => Str::random(10),
        ]);
        $role = Role::where('name', 'Super-Admin')->first();
        $user->assignRole($role->id);
    }
}
