<?php

namespace App\Models\Dataencoding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbtsFile extends Model
{
    use HasFactory;
    protected $table = 'files';

    public function files()
    {
        return $this->morphTo();
    }
}
