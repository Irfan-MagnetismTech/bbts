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
        Schema::create('connectivity_links', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->string('link_type')->nullable();
            $table->string('link_name')->nullable();
            $table->bigInteger('vendor_id')->nullable();
            $table->string('bbts_link_id')->nullable();
            $table->string('from_location')->nullable();
            $table->string('division_id')->nullable();
            $table->string('to_location')->nullable();
            $table->string('from_site')->nullable();
            $table->string('district_id')->nullable();
            $table->string('to_site')->nullable();
            $table->string('thana_id')->nullable();
            $table->string('gps')->nullable();
            $table->string('teck_type')->nullable();
            $table->string('vendor_link_id')->nullable();
            $table->string('vendor_vlan')->nullable();
            $table->string('port')->nullable();
            $table->date('date_of_commissioning')->nullable();
            $table->date('date_of_termination')->nullable();
            $table->date('activation_date')->nullable();
            $table->string('remarks')->nullable();
            $table->string('capacity_type')->nullable();
            $table->string('existing_capacity')->nullable();
            $table->string('new_capacity')->nullable();
            $table->string('terrif_per_month')->nullable();
            $table->string('amount')->nullable();
            $table->string('vat')->nullable();
            $table->string('vat_percent')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('connectivity_links');
    }
};
