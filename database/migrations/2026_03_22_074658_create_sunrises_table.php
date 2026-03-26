<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sunrises', function (Blueprint $table) {
            $table->id();
            $table->string('location')->default('Nabire');
            $table->date('date');
            $table->time('dawn_time');
            $table->time('sunrise_time');
            $table->integer('azimuth_sunrise');
            $table->time('transit_time');
            $table->string('transit_altitude');
            $table->time('sunset_time');
            $table->integer('azimuth_sunset');
            $table->time('dusk_time');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sunrises');
    }
};