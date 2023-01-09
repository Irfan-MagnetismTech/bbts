<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dataencoding\Designation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            ['name'=>'Manager'],
            ['name'=>'Asst. Manager'],
            ['name'=>'Team Leader'],
            ['name'=>'Sr. Executive'],
            ['name'=>'Executive'],
            ['name'=>'Jr. Executive'],
        ];
        foreach($designations as $designation){
            Designation::create($designation);
        }
    }
}
