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
        Schema::create('client_feasibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logical_connectivity_id')->constrained('logical_connectivities')->onDelete('cascade');
            $table->string('feasibility_name')->comment('DNS/SMTP/VPN/VC/BGP')->nullable();
            $table->string('dns_domain')->nullable();
            $table->string('dns_mx_racord')->nullable();
            $table->string('dns_a_racord')->nullable();
            $table->string('dns_reverse_racord')->nullable();
            $table->string('ip')->nullable();
            $table->string('smtp_domain')->nullable();
            $table->string('smtp_server')->nullable();
            $table->string('vpn_purpose')->nullable();
            $table->string('vpn_source_ip')->nullable();
            $table->string('vpn_destination_ip')->nullable();
            $table->string('vpn_bandwidth')->nullable();
            $table->string('vpn_iig_name')->nullable();
            $table->date('vpn_activation_date')->nullable();
            $table->date('vpn_submission_date')->nullable();
            $table->string('vpn_remarks')->nullable();
            $table->date('vc_issue_date')->nullable();
            $table->string('vc_source_ip')->nullable();
            $table->string('vc_destination_ip')->nullable();
            $table->string('vc_iig_name')->nullable();
            $table->string('vc_itc')->nullable();
            $table->string('vc_renewal')->nullable();
            $table->string('vc_remarks')->nullable();
            $table->string('primary_peering')->nullable();
            $table->string('secondary_peering')->nullable();
            $table->string('client_prefix')->nullable();
            $table->string('client_as')->nullable();
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
        Schema::dropIfExists('client_feasibilities');
    }
};
