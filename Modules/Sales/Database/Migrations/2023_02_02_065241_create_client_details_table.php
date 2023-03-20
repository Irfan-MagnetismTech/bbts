<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Admin\Entities\Branch;
use Modules\Admin\Entities\Pop;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreignIdFor(Branch::class);
            $table->foreignIdFor(Pop::class);
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fr_id')->nullable();
            $table->string('fr_composite_key')->nullable();
            $table->string('link_name')->nullable();
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
        Schema::dropIfExists('client_details');
    }
};
