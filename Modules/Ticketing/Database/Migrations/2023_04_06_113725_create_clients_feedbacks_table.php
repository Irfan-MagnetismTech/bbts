<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Admin\Entities\Branch;
use Modules\Admin\Entities\Pop;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\ClientDetail;
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
        Schema::create('clients_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SupportTicket::class);
            $table->string('rating');
            $table->string('feedback')->nullable();
            $table->foreignIdFor(ClientDetail::class);
            $table->foreignIdFor(Client::class);
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
        Schema::dropIfExists('pop_wise_issues');
    }
};
