<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = [
                    ["division_id"=>4, "name"=>"Bagerhat"],
                    ["division_id"=>2, "name"=>"Bandarban"],
                    ["division_id"=>1, "name"=>"Barguna"],
                    ["division_id"=>1, "name"=>"Barishal"],
                    ["division_id"=>1, "name"=>"Bhola"],
                    ["division_id"=>5, "name"=>"Bogura"],
                    ["division_id"=>2, "name"=>"Brahmanbaria"],
                    ["division_id"=>2, "name"=>"Chandpur"],
                    ["division_id"=>5, "name"=>"Chapainawabganj"],
                    ["division_id"=>2, "name"=>"Chattogram"],
                    ["division_id"=>4, "name"=>"Chuadanga"],
                    ["division_id"=>2, "name"=>"Cox''s Bazar"],
                    ["division_id"=>2, "name"=>"Cumilla"],
                    ["division_id"=>3, "name"=>"Dhaka"],
                    ["division_id"=>6, "name"=>"Dinajpur"],
                    ["division_id"=>3, "name"=>"Faridpur"],
                    ["division_id"=>2, "name"=>"Feni"],
                    ["division_id"=>6, "name"=>"Gaibandha"],
                    ["division_id"=>3, "name"=>"Gazipur"],
                    ["division_id"=>3, "name"=>"Gopalganj"],
                    ["division_id"=>7, "name"=>"Habiganj"],
                    ["division_id"=>5, "name"=>"Jaipurhat"],
                    ["division_id"=>8, "name"=>"Jamalpur"],
                    ["division_id"=>4, "name"=>"Jashore"],
                    ["division_id"=>1, "name"=>"Jhalokati"],
                    ["division_id"=>4, "name"=>"Jhenaidah"],
                    ["division_id"=>2, "name"=>"Khagrachhari"],
                    ["division_id"=>4, "name"=>"Khulna"],
                    ["division_id"=>3, "name"=>"Kishoreganj"],
                    ["division_id"=>6, "name"=>"Kurigram"],
                    ["division_id"=>4, "name"=>"Kushtia"],
                    ["division_id"=>2, "name"=>"Lakshmipur"],
                    ["division_id"=>6, "name"=>"Lalmonirhat"],
                    ["division_id"=>3, "name"=>"Madaripur"],
                    ["division_id"=>4, "name"=>"Magura"],
                    ["division_id"=>3, "name"=>"Manikganj"],
                    ["division_id"=>4, "name"=>"Meherpur"],
                    ["division_id"=>7, "name"=>"Moulvibazar"],
                    ["division_id"=>3, "name"=>"Munshiganj"],
                    ["division_id"=>8, "name"=>"Mymensingh"],
                    ["division_id"=>5, "name"=>"Naogaon"],
                    ["division_id"=>4, "name"=>"Narail"],
                    ["division_id"=>3, "name"=>"Narayanganj"],
                    ["division_id"=>3, "name"=>"Narsingdi"],
                    ["division_id"=>5, "name"=>"Natore"],
                    ["division_id"=>8, "name"=>"Netrokona"],
                    ["division_id"=>6, "name"=>"Nilphamari"],
                    ["division_id"=>2, "name"=>"Noakhali"],
                    ["division_id"=>5, "name"=>"Pabna"],
                    ["division_id"=>6, "name"=>"Panchagarh"],
                    ["division_id"=>1, "name"=>"Patuakhali"],
                    ["division_id"=>1, "name"=>"Pirojpur"],
                    ["division_id"=>3, "name"=>"Rajbari"],
                    ["division_id"=>5, "name"=>"Rajshahi"],
                    ["division_id"=>2, "name"=>"Rangamati"],
                    ["division_id"=>6, "name"=>"Rangpur"],
                    ["division_id"=>4, "name"=>"Satkhira"],
                    ["division_id"=>3, "name"=>"Shariatpur"],
                    ["division_id"=>8, "name"=>"Sherpur"],
                    ["division_id"=>5, "name"=>"Sirajgonj"],
                    ["division_id"=>7, "name"=>"Sunamganj"],
                    ["division_id"=>7, "name"=>"Sylhet"],
                    ["division_id"=>3, "name"=>"Tangail"],
                    ["division_id"=>6, "name"=>"Thakurgaon"],
        ];
        foreach($districts as $district){ 
            \App\Models\Dataencoding\District::create($district);
        }
    }
}
