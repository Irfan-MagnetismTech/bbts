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
        Schema::create('logical_connectivities', function (Blueprint $table) {
            $table->id();
            $table->string('client_no')->nullable();
            $table->string('fr_no')->nullable();
            $table->string('product_category')->comment('Internet/Data/VAS')->nullable();
            $table->string('shared_type')->comment('dedicated, Shared')->nullable();
            $table->string('feasility_type')->comment('DNS/SMTP/VPN/VC/BGP')->nullable();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('logical_connectivities');
    }
};
