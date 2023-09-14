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
            ['name'=>'Deputy General Manager & Head of Sales & Marketing.'],
            ['name'=>'Sr. Manager'],
            ['name'=>'Manager'],
            ['name'=>'Manager Network & Wireless'],
            ['name'=>'Manager Network & Maintenance'],
            ['name'=>'Manager Sales & Marketing'],
            ['name'=>'Deputy Manager Network & Support'],
            ['name'=>'Deputy Manager'],
            ['name'=>'Assistant Manager'],
            ['name'=>'Assistant Manager & Head '],
            ['name'=>'Sr. Engineer'],
            ['name'=>'Sr. Executive Network & Support'],
            ['name'=>'Senior Executive'],
            ['name'=>'Engineer'],
            ['name'=>'Executive'],
            ['name'=>'Deputy Engineer'],
            ['name'=>'Deputy Executive'],
            ['name'=>'Assistant Executive'],
            ['name'=>'Assistant Engineer'],
            ['name'=>'Asst. Officer'],
            ['name'=>'Assistant'],
            ['name'=>'Assistant Front Desk'], 
        ];
        foreach($designations as $designation){
            Designation::create($designation);
        }
    }
}
