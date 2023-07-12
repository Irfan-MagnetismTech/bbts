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
        Schema::create('vas_services', function (Blueprint $table) {
            $table->id();
            $table->string('client_no')->nullable();
            $table->string('fr_no')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('vendor_id')->nullable();
            $table->date('date')->nullable();
            $table->date('required_date')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('vas_services');
    }
};
