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
            $table->foreignId('branches_id');
            $table->foreignId('pops_id');
            $table->foreignId('divisions_id');
            $table->foreignId('districts_id');
            $table->foreignId('thanas_id');
            $table->foreignId('clients_id');
            $table->string('ticket_no')->comment('format: YYMMDD-000001');
            $table->foreignId('fr_composit_key')->comment('Clients Link ID');
            $table->dateTime('complain_time');
            $table->text('description')->nullable();
            $table->foreignId('complain_types_id');
            $table->foreignId('sources_id');
            $table->string('priority');
            $table->text('remarks')->nullable();
            $table->string('status')->default('Pending');
            $table->foreignId('created_by');
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('reopened_by')->nullable();
            $table->dateTime('opening_date');
            $table->dateTime('closing_date')->nullable();
            $table->dateTime('closed_by')->nullable();
            $table->bigInteger('feedback_to_bbts')->nullable();
            $table->bigInteger('feedback_to_client')->nullable();
            $table->bigInteger('clients_feedback')->nullable();
            $table->bigInteger('current_authorized_person')->nullable();
            $table->tinyInteger('mailNotification')->nullable();
            $table->tinyInteger('smsNotification')->nullable();

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
