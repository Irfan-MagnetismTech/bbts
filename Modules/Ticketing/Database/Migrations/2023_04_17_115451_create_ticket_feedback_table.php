<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Admin\Entities\User;
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
        Schema::create('ticket_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('feedbackable_type');
            $table->string('feedbackable_id');
            $table->string('feedback_to_client')->nullable();
            $table->string('feedback_to_bbts')->nullable();
            $table->dateTime('feedback_date')->nullable();
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
        Schema::dropIfExists('ticket_feedback');
    }
};
