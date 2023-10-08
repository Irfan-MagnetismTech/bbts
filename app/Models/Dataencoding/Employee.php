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
    public function preDivision()
    {
        return $this->belongsTo(Division::class, 'pre_division_id');
    }
    public function perDivision()
    {
        return $this->belongsTo(Division::class, 'per_division_id');
    }
    public function preDistrict()
    {
        return $this->belongsTo(district::class, 'pre_district_id');
    }
    public function perDistrict()
    {
        return $this->belongsTo(district::class, 'per_district_id');
    }
    public function preThana()
    {
        return $this->belongsTo(Thana::class, 'pre_thana_id');
    }
    public function perThana()
    {
        return $this->belongsTo(Thana::class, 'per_thana_id');
    }
}
