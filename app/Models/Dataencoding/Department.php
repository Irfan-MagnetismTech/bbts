<?php

namespace App\Models\Dataencoding;

use App\Models\Dataencoding\Employee;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dataencoding\Designation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function designations()
    {
        return $this->hasMany(Designation::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
