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
        Schema::create('pops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->integer('division_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('thana_id')->nullable();
            $table->string('address')->nullable();
            $table->integer('branch_id')->nullable();
            $table->string('lat_long')->nullable();
            $table->string('owners_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('designation')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
            $table->string('description')->nullable();
            $table->date('approval_date')->nullable();
            $table->date('btrc_approval_date')->nullable();
            $table->date('commissioning_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->date('website_published_date')->nullable();
            $table->string('signboard')->nullable();
            $table->double('advance_amount', 8, 2)->nullable();
            $table->double('rent', 8, 2)->nullable();
            $table->double('advance_reduce', 8, 2)->nullable();
            $table->double('monthly_rent', 8, 2)->nullable();
            $table->string('paymet_method')->nullable();
            $table->integer('bank_id')->nullable();
            $table->string('account_no')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('routing_no')->nullable();
            $table->string('remarks')->nullable();
            $table->string('attached_file')->nullable();
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
        Schema::dropIfExists('pops');
    }
};
