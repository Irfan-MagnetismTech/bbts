<?php

namespace Modules\Admin\Entities;

use Modules\Admin\Entities\Zone;
use App\Models\Dataencoding\Thana;
use Illuminate\Database\Eloquent\Model;

class ZoneLine extends Model
{
    protected $fillable = ['zone_id', 'thana_id'];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function thana()
    {
        return $this->belongsTo(Thana::class);
    }
}
