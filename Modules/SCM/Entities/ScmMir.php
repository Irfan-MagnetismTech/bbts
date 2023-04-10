<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;

class ScmMir extends Model
{
    protected $fillable = [
        'mir_no',
        'scm_requisition_id',
        'date',
        'to_branch_id',
        'pop_id',
        'courier_id',
        'courier_serial_no',
        'remarks',
        'created_by',
        'branch_id'
    ];
}
