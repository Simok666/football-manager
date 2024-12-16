<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendance_schedules', function (Blueprint $table) {
            $table->text('attendance_status')->nullable()->after('attendance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_schedules', function (Blueprint $table) {
            $table->dropColumn('attendance_status');
        });
    }
};
