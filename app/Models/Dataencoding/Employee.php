<?php

namespace App\Models\Dataencoding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function department() {
        return $this->belongsTo(Department::class, 'departments_id', 'id');
    }
}
