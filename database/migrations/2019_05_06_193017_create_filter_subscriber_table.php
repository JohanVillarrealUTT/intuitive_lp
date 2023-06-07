<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterSubscriberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_subscriber', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('filter_id');
            $table->unsignedBigInteger('subscriber_id');
            $table->timestamps();

            $table->foreign('filter_id')
                ->references('id')
                ->on('filters')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->foreign('subscriber_id')
                ->references('id')
                ->on('subscribers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filter_subscriber');
    }
}
