<?php

use App\Models\Dataencoding\Department;
use App\Models\Dataencoding\Designation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Admin\Entities\Branch;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Designation::class);
            $table->foreignIdFor(Department::class);
            $table->foreignIdFor(Branch::class);
            $table->integer('pre_division_id');
            $table->integer('per_division_id')->nullable();
            $table->integer('pre_district_id');
            $table->integer('per_district_id')->nullable();
            $table->integer('pre_thana_id');
            $table->integer('per_thana_id')->nullable();
            $table->string('name');
            $table->string('nid');
            $table->string('blood_group');
            $table->string('father');
            $table->string('mother');
            $table->date('joining_date');
            $table->string('reference')->nullable();
            $table->text('job_experience');
            $table->string('emergency');
            $table->date('dob');
            $table->string('contact');
            $table->string('email');
            $table->string('pre_street_address');
            $table->string('per_street_address')->nullable();
            $table->string('picture')->nullable();
            $table->tinyInteger('address_status')->nullable();
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
        Schema::dropIfExists('employees');
    }
};
