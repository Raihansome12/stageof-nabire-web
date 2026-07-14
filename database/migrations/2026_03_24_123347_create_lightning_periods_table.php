<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lightning_periods', function (Blueprint $table) {
            $table->id();

            $table->integer('year');
            $table->integer('month'); // 1–12
            $table->enum('type', ['mingguan', 'bulanan', 'dasarian']);
            $table->string('label'); // "Week 1", "Dasarian I"

            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lightning_periods');
    }
};
