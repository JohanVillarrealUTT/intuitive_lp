<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentSubscriberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_subscriber', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->text('comment')->nullable();

            $table->enum('status', ['programada', 'si asistio', 'cancelada', 'no asistio'])->nullable();

            $table->unsignedBigInteger('appointment_hour_id')->nullable();
            $table->foreign('appointment_hour_id')->references('id')->on('appointment_hours');

            $table->unsignedBigInteger('subscriber_id')->nullable();
            $table->foreign('subscriber_id')->references('id')->on('subscribers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_subscriber');
    }
}
