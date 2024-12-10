<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->text('phone')->nullable();
            $table->text('name')->nullable();
            $table->text('nik')->nullable();
            $table->text('place_of_birth')->nullable();
            $table->text('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->text('status')->nullable();
            $table->text('emergeny_contact')->nullable();
            $table->text('weight')->nullable();
            $table->text('height')->nullable();
            $table->text('history')->nullable();
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
        Schema::dropIfExists('coaches');
    }
}
