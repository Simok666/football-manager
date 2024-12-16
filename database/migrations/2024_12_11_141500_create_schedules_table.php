<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id(); // Primary key, auto increment
            $table->text('activity'); // Activity description
            $table->date('date_activity'); // Date of the activity
            $table->time('time_start_activity'); // Start time of the activity
            $table->time('time_end_activity'); // End time of the activity
            $table->text('location'); // Location of the activity
            $table->timestamps(); // Created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
