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
        Schema::create('support_team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id');
            $table->foreignId('branches_id');
            $table->foreignId('support_teams_id')->constrained('support_teams', 'id')->cascadeOnDelete();
            $table->integer('type')->comment('User Level');
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
        Schema::dropIfExists('support_team_members');
    }
};
