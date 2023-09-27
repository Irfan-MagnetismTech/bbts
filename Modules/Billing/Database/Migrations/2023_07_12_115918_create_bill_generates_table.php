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
        Schema::create('bill_generates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->nullable();
            $table->string('client_no')->nullable();
            $table->bigInteger('billing_address_id')->nullable();
            $table->date('date')->nullable();
            $table->string('month')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('bill_type')->comment('OTC/Monthly Bill/Broken Days');
            $table->bigInteger('amount')->nullable();
            $table->double('penalty', 8, 2)->nullable();
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
        Schema::dropIfExists('bill_generates');
    }
};
