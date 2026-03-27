<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informasi_publik', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['berita', 'pengumuman']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('published_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('informasi_publik');
    }
};
