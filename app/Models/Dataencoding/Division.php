<?php

namespace App\Models\Dataencoding;

use Modules\Admin\Entities\Branch;
use App\Models\Dataencoding\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Division extends Model
{
    protected $fillable = ['name'];

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function branchs()
    {
        return $this->hasMany(Branch::class);
    }
}
