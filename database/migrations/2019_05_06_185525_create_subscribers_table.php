<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->bigIncrements('id');

            // step 1
            $table->unsignedBigInteger('area_id')->default(1);
            $table->string('name');
            $table->string('last_name');
            $table->string('nickname')->nullable();
            $table->string('email')->unique();
            $table->date('birth_date');
            $table->string('gender')->nullable();
            $table->string('marital_status');
            $table->string('phone')->unique();
            $table->string('home_phone')->nullable();
            $table->string('zip_code');
            $table->string('address');
            $table->string('transportation');
            $table->string('visa');

            // step 2
            $table->string('school_degree');
            $table->string('school_name')->nullable();
            $table->string('school_career')->nullable();
            $table->string('school_training')->nullable();
            $table->string('still_studying');
            $table->string('still_studying_name')->nullable();
            $table->string('still_studying_schedule')->nullable();
            $table->string('still_studying_school')->nullable();
            $table->string('english');
            
            // step 3
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->json('jobs');
            $table->string('vacancy_found_by');
            $table->string('referenced_by')->nullable();
            $table->string('ex_worker')->nullable();

            //admin related
            $table->string('system_status')->default('Rejected');
            $table->string('color_tag')->default('gray');
            $table->boolean('candidate')->default(false);
            $table->boolean('rejected')->default(false);
            $table->timestamps();

            //foreign keys
            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
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
        Schema::dropIfExists('subscribers');
    }
}
