<?php

namespace Modules\Admin\Entities;

use Binafy\LaravelUserMonitoring\Traits\Actionable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Actionable;

    protected $guarded = [];
}
