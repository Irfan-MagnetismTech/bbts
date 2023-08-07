<?php

namespace Modules\Networking\Entities;

use Illuminate\Database\Eloquent\Model;

class Connectivity extends Model
{
    protected $fillable = [
        'sale_id',
        'client_no',
        'fr_no',
        'attendant_engineer',
        'commissioning_Date'
    ];
}
