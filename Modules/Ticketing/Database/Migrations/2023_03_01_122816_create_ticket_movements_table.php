<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Ticketing\Entities\SupportTicket;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SupportTicket::class)->constrained()->cascadeOnDelete();
            $table->foreignId('movement_by');
            $table->foreignId('movement_to');
            $table->string('type');
            $table->string('movement_model');
            $table->string('status');
            $table->text('remarks')->nullable();
            $table->dateTime('movement_date');
            // $table->foreignIdFor(SupportTicketAssignment::class)->constrained()->cascadeOnDelete()->nullable();
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
        Schema::dropIfExists('ticket_movements');
    }
};
