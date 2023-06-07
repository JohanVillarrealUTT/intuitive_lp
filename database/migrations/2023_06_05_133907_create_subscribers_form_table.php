<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribersFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('subscribers_form', function (Blueprint $table) {
        $table->string('id');
        $table->string('job_interest');

        $table->string('name');
        $table->string('last_name');
        $table->string('phone');
        $table->string('email');

        $table->string('work_experience');
        $table->string('equipment_handling');
        $table->string('material_control');
        $table->string('schedule_availability')->nullable();
        $table->string('certificate');
        $table->string('english_level')->nullable();

        $table->string('cv_path')->nullable();

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
        Schema::dropIfExists('subscribers_form');
    }
}
