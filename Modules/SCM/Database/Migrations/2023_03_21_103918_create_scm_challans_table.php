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
        Schema::create('scm_challans', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('challan_no')->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('scm_requisition_id')->nullable();
            $table->string('purpose')->nullable();
            $table->string('client_no')->nullable();
            $table->string('fr_no')->nullable();
            $table->string('link_no')->nullable();
            $table->string('equipment_type')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('pop_id')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('scm_challans');
    }
};
