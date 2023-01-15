<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'description','is_allocate'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function requisitionApproval(){
        return $this->hasOne(RequisitionApproval::class);
    }
}
