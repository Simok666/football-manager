<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_schedules', function (Blueprint $table) {
            $table->id(); // Primary key, auto increment
            
            // Foreign key for schedule
            $table->unsignedBigInteger('schedule_id');
            $table->foreign('schedule_id')
                  ->references('id')
                  ->on('schedules')
                  ->onDelete('cascade');
            
            // Foreign key for user
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // Attendance status
            $table->boolean('attendance')->default(false);
            
            $table->timestamps();

            // Unique constraint to prevent duplicate entries
            $table->unique(['schedule_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_schedules');
    }
}
