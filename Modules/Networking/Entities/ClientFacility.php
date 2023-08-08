<?php

namespace Modules\Networking\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ClientFacility extends Model
{
    
    protected $fillable = [
        'logical_connectivity_id', 'facility_name', 'dns_domain', 'dns_mx_record', 'dns_a_record', 'dns_reverse_record', 'dns_ip_address', 'smtp_domain', 'smtp_server', 'vpn_purpose', 'vpn_source_ip', 'vpn_destination_ip', 'vpn_bandwidth', 'vpn_iig_name', 'vpn_tunnel_active_date', 'vpn_submission_date', 'vpn_remarks', 'vc_issued_date', 'vc_source_ip', 'vc_destination_ip', 'vc_iig_name', 'vc_itc_name', 'vc_renewal_date', 'vc_remarks', 'bgp_primary_peering', 'bgp_secondary_peering', 'bgp_client_prefix', 'bgp_client_as',
    ];
    
    private $dateField = ['vpn_tunnel_active_date', 'vpn_submission_date', 'vc_issued_date', 'vc_renewal_date'];

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->dateField)) {
            $value = !empty($value) ? Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d') : null;
        }

        parent::setAttribute($key, $value);
    }

    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->dateField)) {
            $value = !empty($value) ? Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y') : null;
        }

        return $value;
    }
}
