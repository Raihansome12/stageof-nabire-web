<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lightning_maps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('period_id')
                  ->constrained('lightning_periods')
                  ->cascadeOnDelete();

            $table->string('image_path');
            $table->timestamp('source_updated_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lightning_maps');
    }
};
