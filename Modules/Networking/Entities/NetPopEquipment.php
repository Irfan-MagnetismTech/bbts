<?php

namespace Modules\Networking\Entities;

use Illuminate\Database\Eloquent\Model;

class NetPopEquipment extends Model
{
    protected $fillable = [
        'pop_id', 'material_id', 'serial_code', 'brand', 'model', 'equipment_type', 'ip_id', 'subnet_mask', 'tower_type', 'tower_height', 'made_by', 'maintenance_date', 'capacity', 'port_no', 'installation_date', 'remarks',
    ];
}
