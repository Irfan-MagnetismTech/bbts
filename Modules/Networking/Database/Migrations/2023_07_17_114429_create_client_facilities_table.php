<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logical_connectivity_id')->constrained('logical_connectivities')->onDelete('cascade');
            $table->string('facility_name')->comment('DNS/SMTP/VPN/VC/BGP')->nullable();
            $table->string('dns_domain')->nullable();
            $table->string('dns_mx_record')->nullable();
            $table->string('dns_a_record')->nullable();
            $table->string('dns_reverse_record')->nullable();
            $table->string('dns_ip_address')->nullable();
            $table->string('smtp_domain')->nullable();
            $table->string('smtp_server')->nullable();
            $table->string('vpn_purpose')->nullable();
            $table->string('vpn_source_ip')->nullable();
            $table->string('vpn_destination_ip')->nullable();
            $table->string('vpn_bandwidth')->nullable();
            $table->string('vpn_iig_name')->nullable();
            $table->date('vpn_tunnel_active_date')->nullable();
            $table->date('vpn_submission_date')->nullable();
            $table->string('vpn_remarks')->nullable();
            $table->date('vc_issued_date')->nullable();
            $table->string('vc_source_ip')->nullable();
            $table->string('vc_destination_ip')->nullable();
            $table->string('vc_iig_name')->nullable();
            $table->string('vc_itc_name')->nullable();
            $table->string('vc_renewal_date')->nullable();
            $table->string('vc_remarks')->nullable();
            $table->string('bgp_primary_peering')->nullable();
            $table->string('bgp_secondary_peering')->nullable();
            $table->string('bgp_client_prefix')->nullable();
            $table->string('bgp_client_as')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_facilities');
    }
};
