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
        Schema::create('scm_murs', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->bigInteger('challan_id');
            $table->string('purpose')->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('client_details_id')->nullable();
            $table->string('fr_composite_key')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('pop_id')->nullable();
            $table->string('date')->nullable();
            $table->string('mur_no')->nullable();
            $table->bigInteger('created_by');
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
        Schema::dropIfExists('scm_murs');
    }
};
