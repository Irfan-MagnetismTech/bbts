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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            
            $table->string('ticket_no');
            $table->foreignId('fr_composit_key')->comment('Clients Link ID');
            $table->dateTime('occurance_time');
            $table->text('description');
            $table->foreignId('complain_types_id');
            $table->string('source');
            $table->text('remarks');
            $table->tinyInteger('status');
            $table->foreignId('created_by');
            $table->foreignId('updated_by');
            $table->foreignId('reopened_by');
            $table->dateTime('closing_date');
            $table->dateTime('closed_by');
            $table->bigInteger('feedback_to_bbts');
            $table->bigInteger('feedback_to_client');
            $table->bigInteger('clients_feedback');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->bigInteger('current_authorized_person');
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
        Schema::dropIfExists('support_tickets');
    }
};
