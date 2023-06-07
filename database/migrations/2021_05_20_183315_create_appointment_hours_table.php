<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_hours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('hour', 20);
            $table->integer('max_capacity')->default(35);
            $table->integer('space_available')->default(35);
            $table->enum('status', ['available', 'full'])->nullable()->default('available');
            $table->unsignedBigInteger('appointment_date_id');
            $table->foreign('appointment_date_id')->references('id')->on('appointment_dates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_hours');
    }
}
