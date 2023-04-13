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
        Schema::create('client_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id')->unsigned();
            $table->integer('lead_generation_id')->unsigned();
            $table->string('reason_of_switching')->nullable();
            $table->string('lan_issue')->nullable();
            $table->string('device')->nullable();
            $table->string('capablity_of_bandwidth')->nullable();
            $table->string('device_connected_with_lan')->nullable();
            $table->string('license_of_antivirus')->nullable();
            $table->string('client_site_it_person')->nullable();
            $table->string('mail_domain')->nullable();
            $table->string('vpn_requirement')->nullable();
            $table->string('video_conferencing')->nullable();
            $table->string('istsp_service_usage')->nullable();
            $table->string('software_usage')->nullable();
            $table->string('specific_designation')->nullable();
            $table->string('uptime_capable_sla')->nullable();
            $table->string('isp_providing')->nullable();
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
        Schema::dropIfExists('client_questions');
    }
};
