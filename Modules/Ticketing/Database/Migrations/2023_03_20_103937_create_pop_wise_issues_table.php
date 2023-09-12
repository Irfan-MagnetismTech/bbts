<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Admin\Entities\Branch;
use Modules\Admin\Entities\Pop;
use Modules\Sales\Entities\Client;
// use Modules\Sales\Entities\ClientDetail;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pop_wise_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Branch::class);
            $table->foreignIdFor(Pop::class);
            // $table->foreignIdFor(ClientDetail::class);
            $table->foreignIdFor(Client::class);
            $table->string('subject');
            $table->string('status', 20)->default('Open');
            $table->dateTime('issue_started')->nullable();
            $table->dateTime('issue_resolved')->nullable();
            $table->string('duration', 20)->nullable();
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
