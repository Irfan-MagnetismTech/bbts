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
        Schema::create('scm_mirs', function (Blueprint $table) {
            $table->id();
            $table->string('mir_no')->nullable();
            $table->integer('scm_purchase_requisition_id')->nullable();
            $table->date('date')->nullable();
            $table->integer('to_branch_id')->nullable();
            $table->integer('pop_id')->nullable();
            $table->integer('courier_id')->nullable();
            $table->string('courier_serial_no')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('branch_id')->nullable();
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
        Schema::dropIfExists('scm_mirs');
    }
};
