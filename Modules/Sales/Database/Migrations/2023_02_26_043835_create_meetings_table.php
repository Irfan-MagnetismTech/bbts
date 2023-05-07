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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->date('visit_date')->nullable();
            $table->string('sales_representative')->nullable();
            $table->time('meeting_start_time')->nullable();
            $table->time('meeting_end_time')->nullable();
            $table->string('meeting_place')->nullable();
            $table->integer('client_id')->nullable();
            $table->text('purpose')->nullable();
            $table->string('status')->nullable()->default('Pending');
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
        Schema::dropIfExists('meetings');
    }
};
