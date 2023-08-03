<?php

use Kalnoy\Nestedset\NestedSet;
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
        Schema::create('net_fiber_management', function (Blueprint $table) {
            $table->id();
            NestedSet::columns($table);
            $table->integer('pop_id');
            $table->string('connectivity_point_name')->nullable();
            $table->string('cable_code')->nullable();
            $table->string('fiber_type')->nullable();
            $table->string('core_no_color')->nullable();
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
        Schema::dropIfExists('net_fiber_management');
        Schema::table('net_fiber_management', function (Blueprint $table) {
            NestedSet::dropColumns($table);
        });
    }
};
