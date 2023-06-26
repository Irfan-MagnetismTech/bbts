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
        Schema::create('followups', function (Blueprint $table) {
            $table->id();
            $table->integer('meeting_id')->nullable();
            $table->date('activity_date')->nullable();
            $table->time('work_start_time')->nullable();
            $table->time('work_end_time')->nullable();
            $table->string('work_nature_type')->nullable();
            $table->string('client_type')->nullable();
            $table->string('sales_type')->nullable();
            $table->string('client_no')->nullable();
            $table->float('potentility_amount')->nullable();
            $table->text('meeting_outcome')->nullable();
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
        Schema::dropIfExists('followups');
    }
};
