<?php

namespace Modules\SCM\Entities;

use Illuminate\Database\Eloquent\Model;

class ScmMurLine extends Model
{
    protected $guarded = [];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
