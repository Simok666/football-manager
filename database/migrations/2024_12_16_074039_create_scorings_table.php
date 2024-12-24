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
        Schema::create('scorings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('schedule_id');
            
            // Discipline Enum
            $table->enum('discipline', [
                'Selalu hadir dan tidak pernah terlambat', 
                'Selalu hadir namun terlambat', 
                'Jarang hadir dan sering terlambat'
            ]);
            
            // Attitude Enum
            $table->enum('attitude', [
                'Dapat menerima arahan pelatih dan bisa bermain dalam tim', 
                'Salah satu dari kriteria kurang', 
                'Tidak bisa menerima arahan pelatih dan tidak bisa bermain dalam tim'
            ]);
            
            // Stamina Enum
            $table->enum('stamina', [
                'Durability & Consistency stabil', 
                'Durability or consistency not stabil', 
                'Durability and consistency low'
            ]);
            
            // Injury Enum
            $table->enum('injury', [
                'Tidak ada cidera dalam 1 bulan', 
                'Cidera max. 2x sebulan', 
                'Cidera lebih dari 2x sebulan'
            ]);
            
            // Performance Metrics
            $table->text('goals')->nullable();
            $table->text('assists')->nullable();
            $table->text('shots_on_target')->nullable();
            $table->text('successful_passes')->nullable();
            $table->text('chances_created')->nullable();
            $table->text('tackles')->nullable();
            $table->text('interceptions')->nullable();
            $table->text('clean_sheets')->nullable();
            $table->text('saved')->nullable();
            $table->text('offsides')->nullable();
            $table->text('foul')->nullable();
            
            $table->text('improvement')->nullable();
            
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scorings');
    }
};
