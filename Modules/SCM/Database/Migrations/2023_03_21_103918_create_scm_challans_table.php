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
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('client_details_id')->nullable();
            $table->string('fr_composite_key')->nullable();
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
