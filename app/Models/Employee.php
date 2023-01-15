<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = ['division_id','district_id'];
    public function setDobAttribute($input)
    {
        !empty($input) ? $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }
    public function getDobAttribute($input)
    {
        $dob = !empty($input) ? Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y') : null;
        return $dob;
    }
    public function getFullNameAttribute()
    {
        return $this->fname . ' ' . $this->lname;
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id')->withDefault()->withDefault();
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id')->withDefault();
    }
    public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }
    public function preThana()
    {
        return $this->belongsTo(Thana::class, 'pre_thana_id')->withDefault();
    }
    public function perThana()
    {
        return $this->belongsTo(Thana::class, 'per_thana_id');
    }

    public function requisitionApproval(){
//        return $this->hasOne(RequisitionApproval::class, 'department_id');
        return $this->hasOne(RequisitionApproval::class, 'department_id');
    }
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id')->withDefault();
    }
}
