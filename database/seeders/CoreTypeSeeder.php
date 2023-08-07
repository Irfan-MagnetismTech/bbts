<?php

namespace Database\Seeders;

use App\Models\CoreNoColor;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Modules\Admin\Entities\User;
use Spatie\Permission\Models\Role;
use Modules\Networking\Entities\CoreType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoreTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coreTypes = [
            ['name' => '4 Core'],
            ['name' => '8 Core'],
            ['name' => '12 Core'],
            ['name' => '16 Core'],
            ['name' => '20 Core'],
            ['name' => '24 Core'],
            ['name' => '28 Core'],
            ['name' => '32 Core'],
            ['name' => '36 Core'],
        ];
        foreach ($coreTypes as $coreType) {
            CoreType::create($coreType);
        }
    }
}
