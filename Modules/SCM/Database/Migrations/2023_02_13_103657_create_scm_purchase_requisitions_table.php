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
        Schema::create('scm_purchase_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('psr_no');
            $table->string('type')->nullable();
            $table->date('date')->nullable();
            $table->integer('client_id')->nullable();
            $table->string('fr_compound_key')->nullable();
            $table->string('assessment_no')->nullable();
            $table->integer('requisition_by');
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
        Schema::dropIfExists('scm_purchase_requisitions');
    }
};
