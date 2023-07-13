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
        Schema::create('logical_connectivity_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logical_connectivity_id')->constrained('logical_connectivities')->onDelete('cascade');
            $table->string('product_category')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('ip_ipv4')->nullable();
            $table->string('ip_ipv6')->nullable();
            $table->string('subnetmask')->nullable();
            $table->string('gateway')->nullable();
            $table->string('vlan')->nullable();
            $table->string('mrtg_user')->nullable();
            $table->string('mrtg_pass')->nullable();
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
        Schema::dropIfExists('logical_connectivity_lines');
    }
};
