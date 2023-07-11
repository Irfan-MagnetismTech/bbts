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
        Schema::create('billing_otc_bills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->nullable();
            $table->string('client_no')->nullable();
            $table->string('fr_no')->nullable();
            $table->date('date')->nullable();
            $table->bigInteger('equipment_amount')->nullable();
            $table->bigInteger('installation_charge')->nullable();
            $table->bigInteger('total_amount')->nullable();
            $table->string('particular')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
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
        Schema::dropIfExists('billing_otc_bills');
    }
};
