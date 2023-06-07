<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->string('value');
            $table->string('marketing_code')->nullable();
            $table->string('header_img')->nullable();
            $table->string('background_img')->nullable();
            $table->string('side_left')->nullable();
            $table->string('side_right')->nullable();
            $table->string('main_color')->nullable();
            $table->string('background_color')->nullable();
            $table->string('header_color')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('areas');
    }
}
