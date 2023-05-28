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
        Schema::create('scm_wcrs', function (Blueprint $table) {
            $table->id();
            $table->string('wcr_no')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->date('date')->nullable();
            $table->date('sending_date')->nullable();
            $table->string('client_no')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('sent_by')->nullable();
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
        Schema::dropIfExists('scm_wcrs');
    }
};
