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
        Schema::create('scm_requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('mrs_no')->nullable();
            $table->string('type')->nullable()->comment('1=Client, 2=Warehouse, 3=POP');
            $table->string('client_no')->nullable();
            $table->string('fr_no')->nullable();
            $table->string('link_no')->nullable();
            $table->date('date')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('pop_id')->nullable();
            $table->integer('requisition_by')->nullable();
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
        Schema::dropIfExists('scm_requisitions');
    }
};
