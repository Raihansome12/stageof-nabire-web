<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('earthquakes', function (Blueprint $table) {
            $table->id();
            $table->decimal('magnitude', 4, 1);
            $table->integer('depth_km');
            $table->decimal('latitude', 8, 5);
            $table->decimal('longitude', 8, 5);
            $table->text('location_description');
            $table->text('felt_intensity')->nullable();
            $table->text('potensi')->nullable();
            $table->datetime('occurred_at');
            $table->text('shakemap_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('earthquakes');
    }
};