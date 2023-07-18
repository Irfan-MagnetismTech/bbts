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
        Schema::create('offer_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers')->onDelete('cascade');
            $table->foreignId('offer_details_id')->constrained('offer_details')->onDelete('cascade');
            $table->string('link_id')->nullable();
            $table->string('link_type')->nullable();
            $table->string('link_no')->nullable();
            $table->string('option')->nullable();
            $table->string('connectivity_status')->nullable();
            $table->string('method')->nullable();
            $table->string('vendor')->nullable();
            $table->string('bts_pop_ldp')->nullable();
            $table->string('distance')->nullable();
            $table->double('client_equipment_amount')->nullable();
            $table->double('otc')->nullable();
            $table->double('mo_cost')->nullable();
            $table->double('offer_otc')->nullable();
            $table->double('total_cost')->nullable();
            $table->double('offer_mrc')->nullable();
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
        Schema::dropIfExists('offer_links');
    }
};
