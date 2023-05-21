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
        Schema::create('scm_errs', function (Blueprint $table) {
            $table->id();
            $table->string('err_no');
            $table->string('type')->nullable();
            $table->date('date')->nullable();
            $table->string('client_no')->nullable();
            $table->string('purpose')->nullable();
            $table->string('fr_no')->nullable();
            $table->string('link_no')->nullable();
            $table->bigInteger('challan_id')->nullable();
            $table->string('reason_of_inactive')->nullable();
            $table->date('inactive_date')->nullable();
            $table->string('equipment_type')->nullable();
            $table->string('assigned_person')->nullable();
            $table->string('return_for')->comment('BBTS/ Inactive Client/Shifting Client/ Methode Change')->nullable();
            $table->string('remarks')->nullable();
            $table->bigInteger('created_by');
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('pop_id')->nullable();
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
        Schema::dropIfExists('scm_errs');
    }
};
