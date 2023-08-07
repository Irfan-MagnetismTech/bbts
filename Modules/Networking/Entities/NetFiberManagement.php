<?php

namespace Modules\Networking\Entities;

use Kalnoy\Nestedset\NodeTrait;
use Modules\Admin\Entities\Pop;
use Illuminate\Database\Eloquent\Model;

class NetFiberManagement extends Model
{
    use NodeTrait;
    protected $guarded = [];

    public function getCoreRefIdAttribute()
    {
        return ($this->connectivity_point_name . '-' . $this->cable_code . '-' . $this->core_no_color);
    }
    public function parent()
    {
        return $this->belongsTo($this, 'parent_id', 'id')->withDefault();
    }
    public function childs()
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }

    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }
    public function getRootNode()
    {
        return $this->isRoot() ? $this : $this->parent->getRootNode();
    }

    public function Pop()
    {
        return $this->belongsTo(Pop::class, 'pop_id');
    }
}
