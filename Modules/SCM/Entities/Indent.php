<?php

namespace Modules\SCM\Entities;

use Carbon\Carbon;
use Modules\Admin\Entities\User;
use Modules\SCM\Entities\IndentLine;
use Illuminate\Database\Eloquent\Model;
use Modules\SCM\Entities\ScmPurchaseRequisition;

class Indent extends Model
{
    protected $guarded = [];

    /**
     * @param $input
     */
    public function getDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-m-Y');
    }

    /**
     * @param $input
     */
    public function setDateAttribute($input)
    {
        !empty($input) ? $this->attributes['date'] = Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d') : null;
    }

    public function indentLines()
    {
        return $this->hasMany(IndentLine::class, 'indent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'indent_by', 'id');
    }
}
