<?php

namespace App\Models\Dataencoding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['division_id', 'name'];

    public function division()
    {
        return $this->belongsTo(Division::class)->withDefault();
    }
}

