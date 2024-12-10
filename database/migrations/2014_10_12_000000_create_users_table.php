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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->integer('nik')->nullable();
            $table->text('place_of_birth')->nullable();
            $table->date('birth_of_date')->nullable();
            $table->text('address')->nullable();
            $table->text('school')->nullable();
            $table->text('class')->nullable();
            $table->text('father_name')->nullable();
            $table->text('mother_name')->nullable();
            $table->text('parents_contact')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('height')->nullable();
            $table->unsignedBigInteger('id_positions')->nullable();
            $table->text('history')->nullable();
            $table->unsignedBigInteger('id_contributions')->nullable();
            $table->unsignedBigInteger('id_statuses')->nullable();
            $table->text('strength')->nullable();
            $table->text('Weakness')->nullable();

            $table->foreign('id_positions')->references('id')->on('positions');
            $table->foreign('id_contributions')->references('id')->on('contributions');
            $table->foreign('id_statuses')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
