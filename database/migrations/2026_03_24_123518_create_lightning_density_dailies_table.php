<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lightning_density_daily', function (Blueprint $table) {
            $table->id();

            $table->foreignId('period_id')
                  ->constrained('lightning_periods')
                  ->cascadeOnDelete();

            $table->date('date');
            $table->integer('total_density');

            $table->timestamps();

            // prevent duplicate date in same period
            $table->unique(['period_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lightning_density_daily');
    }
};
