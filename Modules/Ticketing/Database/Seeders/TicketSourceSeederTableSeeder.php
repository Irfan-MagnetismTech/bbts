<?php

namespace Modules\Ticketing\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ticketing\Entities\TicketSource;

class TicketSourceSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $solutions = [
            'Email',
            'Phone',
            'Telephone',
            'Website'
        ];

        foreach($solutions as $solution) {
            TicketSource::create([
                'name' => $solution,
                'created_by'    => 1
            ]);
        }
    }
}
