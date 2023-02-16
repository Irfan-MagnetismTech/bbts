<?php

namespace Modules\Ticketing\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ticketing\Entities\SupportComplainType;

class ComplainTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $complainTypes = [
            '(Both) Bandwidth Issue & Equipment related issue',
            '(Both) equipment related issue & Configuration',
            '(Both) equipment related issue & Specific site issue',
            '(Both) NTTN/Backbone issue & Fiber DB issue',
            'Bandwidth issue',
            'Slow Browsing',
            'Specific site/software/server issue',
            'Mail related issue',
            'IP conflict',
            'Configuration',
            'Equipment related issue',
            'LAN related issue',
            'Link Fluctuation',
            'Paacket Loss/High Latency',
            'Link Shift',
            'Logical Issue',
            'Broadcast Issue',
            'Maintenance Work',
            'NTTN/Backbone Issue',
            'Optical Fiber Break Down',
            'Optical Fiber Burn',
            'Optical Fiber DB Issue',
            'Optical Fiber Stolen',
            'Commercial Power Issue',
            'Power Problem at Client End',
            'Transmission Problem',
            'Request',
            'Queries (Frequent Problem)',
            'Third Party Vendor Link',
            'Billing Issue',
            'Browsing Problem',
            'Checked & Found Service Ok',
            'Device Restarted',
            'Switch Port Restarted',
            'Loose Connectivity',
            'Wrong Port Connection',
            'Others'
        ];

        foreach($complainTypes as $type) {
            SupportComplainType::create([
                'name' => $type,
                'created_by' => 1
            ]);
        }
    }
}
