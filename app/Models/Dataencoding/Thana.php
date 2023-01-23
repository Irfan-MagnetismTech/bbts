<?php

namespace App\Models\Dataencoding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thana extends Model
{
    protected $fillable=['district_id', 'name'];

//    public  function students (){
//        return $this->hasMany(Student::class);
//    }
    public  function employee (){
        return $this->hasMany(Employee::class);
    }

    public  function district (){
        return $this->belongsTo(District::class)->withDefault();
    }
}

