<?php

namespace Modules\Networking\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Entities\Ip;
use Modules\Admin\Entities\Pop;
use Modules\SCM\Entities\Material;

class NetPopEquipment extends Model
{
    protected $fillable = [
        'pop_id', 'material_id', 'serial_code', 'brand', 'model', 'equipment_type', 'ip_id', 'subnet_mask', 'gateway', 'tower_type', 'tower_height', 'made_by', 'maintenance_date', 'capacity', 'port_no', 'installation_date', 'remarks',
    ];

    public function pop()
    {
        return $this->belongsTo(Pop::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function ip()
    {
        return $this->belongsTo(Ip::class);
    }
}
