<?php

namespace App\Models\Dataencoding;

use Illuminate\Database\Eloquent\Model;


class Employee extends Model
{
    protected $guarded = [];

    public function department() {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function designation() {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
}
